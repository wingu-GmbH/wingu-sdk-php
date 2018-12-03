<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Tests\Api\Wingu;

use GuzzleHttp\Psr7\Response;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use Wingu\Engine\SDK\Api\Configuration;
use Wingu\Engine\SDK\Api\Exception\Generic;
use Wingu\Engine\SDK\Api\Wingu\Wingu;
use Wingu\Engine\SDK\Hydrator\Hydrator;
use Wingu\Engine\SDK\Model\Response\Wingu\Ping\Cloudinary;
use Wingu\Engine\SDK\Model\Response\Wingu\Ping\Ping;
use Wingu\Engine\SDK\Model\Response\Wingu\Ping\Version;
use Wingu\Engine\SDK\Tests\Api\ApiTest;

final class WinguTest extends ApiTest
{
    public function testPingThrowsExceptionWhenResponseIsNot200() : void
    {
        $configurationMock = new Configuration();
        $requestFactory    = new GuzzleMessageFactory();
        $hydrator          = $this->createMock(Hydrator::class);

        $httpClient = self::createClient();
        $httpClient->addResponse(
            new Response(500, ['Content-Type' => 'application/json'], '{"code": 500, "errors": []}')
        );

        $winguApi = new Wingu($configurationMock, $httpClient, $requestFactory, $hydrator);

        $this->expectException(Generic::class);
        $this->expectExceptionMessage('Remote server error.');

        $winguApi->ping();
    }

    public function testPingReturnsResult() : void
    {
        $configurationMock = new Configuration();

        $httpClient = self::createClient();
        $httpClient->addResponse(
            new Response(
                200,
                ['Content-Type' => 'application/json'],
                '{"cloudinary":{"cloudName":"abcdefgh"},"version":{"current":"0.10"}}'
            )
        );

        $winguApi = new Wingu($configurationMock, $httpClient);
        $actual   = $winguApi->ping();

        $expected = new Ping(
            new Cloudinary('abcdefgh'),
            new Version('0.10')
        );
        self::assertEquals($expected, $actual);
    }
}
