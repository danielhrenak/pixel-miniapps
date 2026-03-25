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

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Cake\View\Exception\MissingTemplateException;

/**
 * Static content controller
 *
 * This controller will render views from templates/Pages/
 *
 * @link https://book.cakephp.org/5/en/controllers/pages-controller.html
 */
class PagesController extends AppController
{
    /**
     * Displays a view
     *
     * @param string ...$path Path segments.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Http\Exception\ForbiddenException When a directory traversal attempt.
     * @throws \Cake\View\Exception\MissingTemplateException When the view file could not
     *   be found and in debug mode.
     * @throws \Cake\Http\Exception\NotFoundException When the view file could not
     *   be found and not in debug mode.
     * @throws \Cake\View\Exception\MissingTemplateException In debug mode.
     */
    public function display(string ...$path): ?Response
    {
        if (!$path) {
            return $this->redirect('/');
        }
        if (in_array('..', $path, true) || in_array('.', $path, true)) {
            throw new ForbiddenException();
        }
        $page = $subpage = null;

        if (!empty($path[0])) {
            $page = $path[0];
        }
        if (!empty($path[1])) {
            $subpage = $path[1];
        }
        $this->set(compact('page', 'subpage'));

        try {
            return $this->render(implode('/', $path));
        } catch (MissingTemplateException $exception) {
            if (Configure::read('debug')) {
                throw $exception;
            }
            throw new NotFoundException();
        }
    }

    public function abc(): void
    {
        $this->viewBuilder()->disableAutoLayout();
    }
    public function papotv(): void
    {
        $this->viewBuilder()->disableAutoLayout();

        $serverItems = $this->getPapotVSlideShowItems();
        $this->set('serverItemsJson', json_encode($serverItems, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    }

    private function getPapotVSlideShowItems(): array
    {
        $gistApiUrl = 'https://api.github.com/gists/009f73574dc9efa5a00f65777f9d1a8f';
        $defaultItems = [
            [
                'url' => 'https://blog.helveti.cz/wpobsah/uploads/2019/03/postapo.jpg',
                'renderUrl' => 'https://blog.helveti.cz/wpobsah/uploads/2019/03/postapo.jpg',
                'type' => 'image',
                'mimeType' => 'image/jpeg',
            ],
        ];

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
            $detectedType = (str_contains($lowerUrl, '.mp4') || str_contains($lowerUrl, '.webm') || str_contains($lowerUrl, '.mov') || str_contains($lowerUrl, '.ogg'))
                ? 'video'
                : 'image';
        }

        $renderUrl = $url;
        $fileId = $this->getGoogleDriveFileId($url);
        if ($fileId !== null) {
            if ($detectedType === 'video') {
                $renderUrl = sprintf('https://drive.google.com/uc?export=download&id=%s', $fileId);
            } else {
                $renderUrl = sprintf('https://drive.google.com/uc?export=view&id=%s', $fileId);
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

    private function detectRemoteMimeType(string $url): ?string
    {
        if (str_starts_with($url, 'data:')) {
            return null;
        }

        if (function_exists('curl_init')) {
            $ch = curl_init($url);
            if ($ch === false) {
                return null;
            }

            curl_setopt_array($ch, [
                CURLOPT_NOBODY => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_CONNECTTIMEOUT => 5,
                CURLOPT_TIMEOUT => 8,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_USERAGENT => 'pixel-miniapps-papotv',
            ]);

            curl_exec($ch);
            $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
            curl_close($ch);

            return is_string($contentType) && $contentType !== '' ? $contentType : null;
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

    public function abcgame(): void
    {
        $this->viewBuilder()->disableAutoLayout();
    }
}
