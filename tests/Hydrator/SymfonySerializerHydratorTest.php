<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Tests\Hydrator;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Wingu\Engine\SDK\Hydrator\Hydration;
use Wingu\Engine\SDK\Hydrator\SymfonySerializerHydrator;

final class SymfonySerializerHydratorTest extends TestCase
{
    public function testHydrateResponseThrowsExceptionWhenContentTypeIsNotJson() : void
    {
        $response = $this->createMock(ResponseInterface::class);
        $response
            ->expects(self::any())
            ->method('getHeaderLine')
            ->with('Content-Type')
            ->willReturn('text/html');

        $hydrator = new SymfonySerializerHydrator();

        $this->expectException(Hydration::class);
        $hydrator->hydrateResponse($response, \stdClass::class);
    }

    /** @return mixed[] */
    public static function dataProviderTestHydrateResponseValidatesContentTypes() : array
    {
        return [
            ['application/json'],
            ['application/json+custom'],
        ];
    }

    /**
     * @dataProvider dataProviderTestHydrateResponseValidatesContentTypes
     */
    public function testHydrateResponseValidatesContentTypes(string $contentType) : void
    {
        $response = $this->createMock(ResponseInterface::class);
        $response
            ->expects(self::once())
            ->method('getHeaderLine')
            ->with('Content-Type')
            ->willReturn($contentType);

        $responseBody = $this->createMock(StreamInterface::class);
        $responseBody
            ->expects(self::once())
            ->method('getContents')
            ->willReturn('{}');
        $response
            ->expects(self::once())
            ->method('getBody')
            ->willReturn($responseBody);

        $hydrator = new SymfonySerializerHydrator();
        $actual   = $hydrator->hydrateResponse($response, \stdClass::class);

        self::assertEquals(new \stdClass(), $actual);
    }
}
