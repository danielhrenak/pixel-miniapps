<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\PapoController;
use Cake\Controller\Controller;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\TestSuite\TestCase;
use Closure;
use ReflectionClass;

class PapoControllerTest extends TestCase
{
    /**
     * @return array<string, array{0: string, 1: int, 2: array<int, int>|null}>
     */
    public static function parseRangeHeaderProvider(): array
    {
        return [
            'explicit range' => ['bytes=0-1023', 10_000, [0, 1023]],
            'open-ended range' => ['bytes=4096-', 10_000, [4096, 9999]],
            'suffix range' => ['bytes=-512', 10_000, [9488, 9999]],
            'oversized end is clamped' => ['bytes=9000-15000', 10_000, [9000, 9999]],
            'range starting past EOF is invalid' => ['bytes=10000-10001', 10_000, null],
            'range with descending bounds is invalid' => ['bytes=900-100', 10_000, null],
            'empty range is invalid' => ['bytes=-', 10_000, null],
            'unsupported unit is invalid' => ['items=0-10', 10_000, null],
        ];
    }

    /**
     * @dataProvider parseRangeHeaderProvider
     */
    public function testParseRangeHeader(string $header, int $totalSize, ?array $expected): void
    {
        $controller = $this->makeController('GET');
        $parseRangeHeader = Closure::bind(
            fn (string $rangeHeader, int $size): ?array => $this->parseRangeHeader($rangeHeader, $size),
            $controller,
            PapoController::class,
        );

        $actual = $parseRangeHeader($header, $totalSize);

        $this->assertSame($expected, $actual);
    }

    public function testStripBodyForHeadRequestRemovesBodyButKeepsHeaders(): void
    {
        $controller = $this->makeController('HEAD');
        $stripBodyForHeadRequest = Closure::bind(
            fn (Response $response): Response => $this->stripBodyForHeadRequest($response),
            $controller,
            PapoController::class,
        );

        $response = (new Response())
            ->withHeader('Content-Length', '123')
            ->withStringBody('video bytes');

        $actual = $stripBodyForHeadRequest($response);

        $this->assertSame('', (string)$actual->getBody());
        $this->assertSame('123', $actual->getHeaderLine('Content-Length'));
    }

    public function testStripBodyForGetRequestLeavesBodyUntouched(): void
    {
        $controller = $this->makeController('GET');
        $stripBodyForHeadRequest = Closure::bind(
            fn (Response $response): Response => $this->stripBodyForHeadRequest($response),
            $controller,
            PapoController::class,
        );

        $response = (new Response())->withStringBody('video bytes');

        $actual = $stripBodyForHeadRequest($response);

        $this->assertSame('video bytes', (string)$actual->getBody());
    }

    private function makeController(string $requestMethod): PapoController
    {
        $controller = (new ReflectionClass(PapoController::class))->newInstanceWithoutConstructor();

        $initializeController = Closure::bind(
            function (ServerRequest $request, Response $response): void {
                $this->request = $request;
                $this->response = $response;
            },
            $controller,
            Controller::class,
        );

        $initializeController(
            new ServerRequest([
                'environment' => ['REQUEST_METHOD' => strtoupper($requestMethod)],
            ]),
            new Response(),
        );

        return $controller;
    }
}


