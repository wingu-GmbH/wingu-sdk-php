<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Tests\Api;

use GuzzleHttp\Psr7\Response;
use Http\Client\HttpClient;
use Http\Message\RequestFactory;
use Psr\Http\Message\RequestInterface;
use Wingu\Engine\SDK\Api\Configuration;
use Wingu\Engine\SDK\Api\WinguApi;
use Wingu\Engine\SDK\Hydrator\Hydrator;

final class WinguApiTest extends ApiTest
{
    public function testFetchingSameServicesReturnsSameInstance() : void
    {
        $winguApi = new WinguApi(
            new Configuration(),
            $this->createMock(HttpClient::class),
            $this->createMock(RequestFactory::class),
            $this->createMock(Hydrator::class)
        );

        $beacon  = $winguApi->beacon();
        $channel = $winguApi->channel();
        $wingu   = $winguApi->wingu();

        self::assertSame($beacon, $winguApi->beacon());
        self::assertSame($channel, $winguApi->channel());
        self::assertSame($wingu, $winguApi->wingu());
    }

    public function testSendingRequestWithoutApiKeySpecifiedDoesNotCreateApiKeyHeader() : void
    {
        $httpClient = self::createClient();
        $httpClient->addResponse(
            new Response(
                200,
                ['Content-Type' => 'application/json'],
                '{"cloudinary":{"cloudName":"abcdefgh"},"version":{"current":"0.10"}}'
            )
        );

        $requestFactoryMock = $this->createMock(RequestFactory::class);
        $requestFactoryMock
            ->expects(self::once())
            ->method('createRequest')
            ->with(
                'GET',
                'http://test/api/wingu/ping.json',
                []
            )
            ->willReturn($this->createMock(RequestInterface::class));

        $winguApi = new WinguApi(
            new Configuration(null, 'http://test'),
            $httpClient,
            $requestFactoryMock
        );

        $winguApi->wingu()->ping();
    }
}
