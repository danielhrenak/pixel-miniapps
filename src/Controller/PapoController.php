<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Cache\Cache;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Cake\Routing\Router;

/**
 * Static content controller
 *
 * This controller will render views from templates/Pages/
 *
 * @link https://book.cakephp.org/5/en/controllers/pages-controller.html
 */
class PapoController extends AppController
{
    private const SLIDES_CACHE_KEY = 'papotv_slides_v4';
    private const SLIDES_CACHE_CONFIG = 'papotv_slides';

    public function papotv(): void
    {
        $this->viewBuilder()->setLayout('empty');

        $serverItems = $this->getCachedPapotVSlideShowItems();
        $initialIndex = 0;
        $initialItem = $serverItems[$initialIndex] ?? $this->getDefaultSlideItems()[0];

        $this->set('initialItemJson', json_encode($initialItem, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
        $this->set('initialIndex', $initialIndex);
        $this->set('totalItems', count($serverItems));
        $this->set('slideEndpoint', Router::url(['controller' => 'Papo', 'action' => 'item']));
    }

    public function item(): Response
    {
        $this->request->allowMethod(['get']);

        $items = $this->getCachedPapotVSlideShowItems();
        $total = count($items);
        $requestedIndex = (int)$this->request->getQuery('index', 0);
        $normalizedIndex = $total > 0 ? (($requestedIndex % $total) + $total) % $total : 0;
        $item = $items[$normalizedIndex] ?? $this->getDefaultSlideItems()[0];

        $payload = [
            'index' => $normalizedIndex,
            'total' => $total > 0 ? $total : 1,
            'item' => $item,
        ];

        return $this->response
            ->withType('application/json')
            ->withStringBody((string)json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    }

    public function image(string $fileId): Response
    {
        $this->request->allowMethod(['get', 'head']);

        if (!preg_match('/^[a-zA-Z0-9_-]+$/', $fileId)) {
            throw new NotFoundException();
        }

        $remoteUrl = sprintf('https://drive.google.com/uc?export=view&id=%s', $fileId);
        $context = stream_context_create([
            'http' => [
                'method' => 'GET',
                'header' => "User-Agent: pixel-miniapps-papotv\r\n",
                'timeout' => 15,
                'follow_location' => 1,
                'max_redirects' => 5,
                'ignore_errors' => true,
            ],
        ]);

        $body = @file_get_contents($remoteUrl, false, $context);
        $headers = $http_response_header ?? [];
        $contentType = $this->extractContentTypeFromHeaders($headers);

        if ($body === false || $contentType === null) {
            throw new NotFoundException();
        }

        $response = $this->response
            ->withType($contentType)
            ->withHeader('Cache-Control', 'public, max-age=900')
            ->withStringBody($body);

        return $this->stripBodyForHeadRequest($response);
    }

    public function video(string $fileId): Response
    {
        $this->request->allowMethod(['get', 'head']);

        if (!preg_match('/^[a-zA-Z0-9_-]+$/', $fileId)) {
            throw new NotFoundException();
        }

        // Always download the full file — never forward Range to Google Drive because
        // Google Drive does not support suffix ranges (bytes=-N), which browsers rely on
        // to locate the moov atom in non-fast-start MP4s. Range slicing is handled below.
        $remoteUrl = sprintf('https://drive.google.com/uc?export=download&id=%s&confirm=t', $fileId);

        $context = stream_context_create([
            'http' => [
                'method' => 'GET',
                'header' => "User-Agent: pixel-miniapps-papotv\r\n",
                'timeout' => 30,
                'follow_location' => 1,
                'max_redirects' => 10,
                'ignore_errors' => true,
            ],
        ]);

        $body = @file_get_contents($remoteUrl, false, $context);

        $responseHeaders = $http_response_header ?? [];
        $contentType = $this->extractContentTypeFromHeaders($responseHeaders);

        if ($body === false || $contentType === null) {
            throw new NotFoundException();
        }

        $normalizedContentType = strtolower(trim($contentType));
        $isGenericBinary = in_array($normalizedContentType, [
            'application/octet-stream',
            'binary/octet-stream',
            'application/binary',
        ], true);

        if ($isGenericBinary && $this->looksLikeMp4($body)) {
            $contentType = 'video/mp4';
            $normalizedContentType = 'video/mp4';
        }

        if (!str_starts_with($normalizedContentType, 'video/')) {
            throw new NotFoundException();
        }

        $totalSize = strlen($body);
        $rangeHeader = $this->request->getHeaderLine('Range');

        if ($rangeHeader !== '') {
            $range = $this->parseRangeHeader($rangeHeader, $totalSize);
            if ($range === null) {
                $response = $this->response
                    ->withStatus(416)
                    ->withType($contentType)
                    ->withHeader('Cache-Control', 'public, max-age=1800')
                    ->withHeader('Accept-Ranges', 'bytes')
                    ->withHeader('Content-Range', "bytes */{$totalSize}")
                    ->withHeader('Content-Length', '0')
                    ->withStringBody('');

                return $this->stripBodyForHeadRequest($response);
            }

            [$start, $end] = $range;
            $partialLength = $end - $start + 1;

            // Keep the full payload in the response body and let CakePHP's ResponseEmitter
            // honor Content-Range when emitting bytes. If we pre-slice the string body here,
            // non-zero ranges break because the emitter applies the offset again.
            $response = $this->response
                ->withStatus(206)
                ->withType($contentType)
                ->withHeader('Cache-Control', 'public, max-age=1800')
                ->withHeader('Accept-Ranges', 'bytes')
                ->withHeader('Content-Range', "bytes {$start}-{$end}/{$totalSize}")
                ->withHeader('Content-Length', (string)$partialLength)
                ->withStringBody($body);

            return $this->stripBodyForHeadRequest($response);
        }

        $response = $this->response
            ->withType($contentType)
            ->withHeader('Cache-Control', 'public, max-age=1800')
            ->withHeader('Accept-Ranges', 'bytes')
            ->withHeader('Content-Length', (string)$totalSize)
            ->withStringBody($body);

        return $this->stripBodyForHeadRequest($response);
    }

    /**
     * Parse an HTTP Range header value and return [start, end] byte offsets,
     * or null if the range is invalid / unsatisfiable.
     * Handles all three forms: bytes=N-M, bytes=N-, bytes=-N (suffix).
     *
     * @return array{0: int, 1: int}|null
     */
    private function parseRangeHeader(string $rangeHeader, int $totalSize): ?array
    {
        if (!preg_match('/^bytes=(\d*)-(\d*)$/', $rangeHeader, $m)) {
            return null;
        }

        $rawStart = $m[1];
        $rawEnd = $m[2];

        if ($rawStart === '' && $rawEnd === '') {
            return null;
        }

        if ($rawStart === '') {
            // Suffix range: bytes=-N  →  last N bytes
            $suffixLength = (int)$rawEnd;
            if ($suffixLength <= 0) {
                return null;
            }
            $start = max(0, $totalSize - $suffixLength);
            $end = $totalSize - 1;
        } elseif ($rawEnd === '') {
            // Open-ended range: bytes=N-
            $start = (int)$rawStart;
            $end = $totalSize - 1;
        } else {
            $start = (int)$rawStart;
            $end = (int)$rawEnd;
        }

        if ($start >= $totalSize || $start > $end) {
            return null;
        }

        $end = min($end, $totalSize - 1);

        return [$start, $end];
    }

    private function stripBodyForHeadRequest(Response $response): Response
    {
        if (strtoupper($this->request->getMethod()) !== 'HEAD') {
            return $response;
        }

        return $response->withStringBody('');
    }

    private function getCachedPapotVSlideShowItems(): array
    {
        $cachedItems = Cache::read(self::SLIDES_CACHE_KEY, self::SLIDES_CACHE_CONFIG);
        if (is_array($cachedItems) && $cachedItems !== []) {
            return $cachedItems;
        }

        $items = $this->getPapotVSlideShowItems();
        Cache::write(self::SLIDES_CACHE_KEY, $items, self::SLIDES_CACHE_CONFIG);

        return $items;
    }

    private function getDefaultSlideItems(): array
    {
        return [
            [
                'url' => 'https://blog.helveti.cz/wpobsah/uploads/2019/03/postapo.jpg',
                'renderUrl' => 'https://blog.helveti.cz/wpobsah/uploads/2019/03/postapo.jpg',
                'type' => 'image',
                'mimeType' => 'image/jpeg',
            ],
        ];
    }

    private function getPapotVSlideShowItems(): array
    {
        $gistApiUrl = 'https://gist.githubusercontent.com/danielhrenak/009f73574dc9efa5a00f65777f9d1a8f/raw/8176d53430472dfaa578cddeb564af5ee824dda5/gistfile1.txt';
        $defaultItems = $this->getDefaultSlideItems();

        $serverItems = [];
        $httpContext = stream_context_create([
            'http' => [
                'method' => 'GET',
                'header' => "User-Agent: pixel-miniapps-papotv\r\nAccept: application/vnd.github+json\r\n",
                'timeout' => 8,
            ],
        ]);
        $payloadRaw = @file_get_contents($gistApiUrl, false, $httpContext);

        if (is_string($payloadRaw) && $payloadRaw !== '') {
            $payload = json_decode($payloadRaw, true);

            if (is_array($payload) && isset($payload['files']) && is_array($payload['files'])) {
                $rawCollected = [];

                foreach ($payload['files'] as $file) {
                    if (!is_array($file) || !isset($file['content']) || !is_string($file['content'])) {
                        continue;
                    }

                    $content = trim($file['content']);
                    if ($content === '') {
                        continue;
                    }

                    $parsed = json_decode($content, true);
                    if (is_array($parsed)) {
                        $this->appendParsedItems($parsed, $rawCollected);
                    } else {
                        foreach ($this->extractUrlsFromText($content) as $url) {
                            $rawCollected[] = $url;
                        }
                    }
                }

                $seen = [];
                foreach ($rawCollected as $rawItem) {
                    $normalized = $this->normalizeServerItem($rawItem);
                    if ($normalized === null) {
                        continue;
                    }

                    $signature = sprintf('%s|%s', $normalized['url'], $normalized['type']);
                    if (isset($seen[$signature])) {
                        continue;
                    }

                    $seen[$signature] = true;
                    $serverItems[] = $normalized;
                }
            }
        }

        return $serverItems === [] ? $defaultItems : $serverItems;
    }

    private function normalizeServerItem(mixed $raw): ?array
    {
        $url = null;
        $explicitType = null;
        $mimeType = null;

        if (is_string($raw)) {
            $url = trim($raw);
        } elseif (is_array($raw)) {
            foreach (['url', 'src', 'href', 'link'] as $urlKey) {
                if (isset($raw[$urlKey]) && is_string($raw[$urlKey])) {
                    $url = trim($raw[$urlKey]);
                    break;
                }
            }

            $explicitType = $this->normalizeExplicitMediaType(
                $raw['type'] ?? $raw['mediaType'] ?? $raw['kind'] ?? $raw['mediaKind'] ?? $raw['format'] ?? null
            );

            if (isset($raw['mimeType']) && is_string($raw['mimeType'])) {
                $mimeType = trim($raw['mimeType']);
            } elseif (isset($raw['mime']) && is_string($raw['mime'])) {
                $mimeType = trim($raw['mime']);
            }
        }

        if (!is_string($url) || $url === '') {
            return null;
        }

        $detectedType = $explicitType ?? $this->normalizeExplicitMediaType($mimeType);
        $detectUrl = $this->isGoogleDriveUrl($url) ? $this->getDriveDirectLink($url) : $url;

        if ($detectedType === null) {
            if (str_starts_with($url, 'data:video/')) {
                $detectedType = 'video';
            } elseif (str_starts_with($url, 'data:image/')) {
                $detectedType = 'image';
            }
        }

        if ($detectedType === null) {
            $remoteMime = $this->detectRemoteMimeType($detectUrl);
            if (is_string($remoteMime) && $remoteMime !== '') {
                $mimeType = $mimeType ?: $remoteMime;
                $detectedType = str_starts_with(strtolower($remoteMime), 'video/') ? 'video' : 'image';
            }
        }

        if ($detectedType === null) {
            $lowerUrl = strtolower($url);
            $detectedType = (str_contains($lowerUrl, '.mp4') || str_contains($lowerUrl, '.webm') || str_contains($lowerUrl, '.mov') || str_contains($lowerUrl, '.ogg') || str_contains($lowerUrl, '.qt'))
                ? 'video'
                : 'image';
        }

        $renderUrl = $url;
        $fileId = $this->getGoogleDriveFileId($url);
        if ($fileId !== null) {
            if ($detectedType === 'video') {
                $renderUrl = $this->buildDriveVideoProxyUrl($fileId);
            } else {
                $renderUrl = $this->buildDriveImageProxyUrl($fileId);
            }
        }

        return [
            'url' => $url,
            'renderUrl' => $renderUrl,
            'type' => $detectedType,
            'mimeType' => $mimeType,
        ];
    }

    private function normalizeExplicitMediaType(mixed $value): ?string
    {
        if (!is_string($value)) {
            return null;
        }

        $normalized = strtolower(trim($value));
        if ($normalized === '') {
            return null;
        }

        if ($normalized === 'video' || str_starts_with($normalized, 'video/')) {
            return 'video';
        }
        if ($normalized === 'image' || str_starts_with($normalized, 'image/')) {
            return 'image';
        }

        return null;
    }

    private function looksLikeMp4(string $body): bool
    {
        // ISO BMFF/MP4 files typically contain "ftyp" box near the start.
        return str_contains(substr($body, 0, 64), 'ftyp');
    }

    private function isGoogleDriveUrl(string $url): bool
    {
        return str_contains($url, 'drive.google.com');
    }

    private function getGoogleDriveFileId(string $url): ?string
    {
        if (preg_match('#/d/([a-zA-Z0-9_-]+)#', $url, $m)) {
            return $m[1];
        }
        if (preg_match('/[?&]id=([a-zA-Z0-9_-]+)/', $url, $m)) {
            return $m[1];
        }

        return null;
    }

    private function getDriveDirectLink(string $shareUrl): string
    {
        if (!$this->isGoogleDriveUrl($shareUrl)) {
            return $shareUrl;
        }

        $fileId = $this->getGoogleDriveFileId($shareUrl);
        if ($fileId === null) {
            return $shareUrl;
        }

        return sprintf('https://drive.google.com/uc?export=download&id=%s', $fileId);
    }

    private function buildDriveImageProxyUrl(string $fileId): string
    {
        return Router::url(['_name' => 'papotv_image', 'fileId' => $fileId]);
    }

    private function buildDriveVideoProxyUrl(string $fileId): string
    {
        return Router::url(['_name' => 'papotv_video', 'fileId' => $fileId]);
    }

    private function detectRemoteMimeType(string $url): ?string
    {
        if (str_starts_with($url, 'data:')) {
            return null;
        }

        $context = stream_context_create([
            'http' => [
                'method' => 'HEAD',
                'header' => "User-Agent: pixel-miniapps-papotv\r\n",
                'timeout' => 8,
                'ignore_errors' => true,
            ],
        ]);

        $headers = @get_headers($url, true, $context);
        if ($headers === false || !is_array($headers)) {
            return null;
        }

        $contentType = $headers['Content-Type'] ?? $headers['content-type'] ?? null;
        if (is_array($contentType)) {
            $contentType = end($contentType);
        }

        if (is_string($contentType) && $contentType !== '') {
            return trim(explode(';', $contentType)[0]);
        }

        return null;
    }

    private function extractContentTypeFromHeaders(array $headers): ?string
    {
        foreach ($headers as $key => $value) {
            // Associative format: from get_headers($url, true)
            if (is_string($key) && strtolower($key) === 'content-type') {
                if (is_array($value)) {
                    $value = end($value);
                }
                if (is_string($value) && $value !== '') {
                    return trim(explode(';', $value)[0]);
                }
            }

            // Indexed format: from $http_response_header or fopen meta wrapper_data
            // e.g. "Content-Type: image/jpeg; charset=utf-8"
            if (is_int($key) && is_string($value) && stripos($value, 'content-type:') === 0) {
                $parts = explode(':', $value, 2);
                if (isset($parts[1])) {
                    return trim(explode(';', $parts[1])[0]);
                }
            }
        }

        return null;
    }

    private function extractUrlsFromText(string $text): array
    {
        preg_match_all('/https?:\/\/[^\s"\'<>\],]+/i', $text, $matches);

        return $matches[0] ?? [];
    }

    private function appendParsedItems(mixed $parsedValue, array &$target): void
    {
        if (!is_array($parsedValue)) {
            return;
        }

        if (array_is_list($parsedValue)) {
            foreach ($parsedValue as $item) {
                $target[] = $item;
            }

            return;
        }

        foreach (['url', 'src', 'href', 'link'] as $key) {
            if (isset($parsedValue[$key]) && is_string($parsedValue[$key])) {
                $target[] = $parsedValue;
                break;
            }
        }

        foreach (['urls', 'images', 'items', 'media'] as $key) {
            if (isset($parsedValue[$key]) && is_array($parsedValue[$key])) {
                foreach ($parsedValue[$key] as $item) {
                    $target[] = $item;
                }
            }
        }
    }

}
