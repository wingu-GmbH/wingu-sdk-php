<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Tests\Api\Component\Proxy;

use GuzzleHttp\Psr7\Response;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use Http\Mock\Client as MockClient;
use Psr\Http\Message\RequestInterface;
use Wingu\Engine\SDK\Api\Component\ProxyApi;
use Wingu\Engine\SDK\Api\Configuration;
use Wingu\Engine\SDK\Hydrator\SymfonySerializerHydrator;
use Wingu\Engine\SDK\Model\Request\Component\Proxy\Create;
use Wingu\Engine\SDK\Model\Request\Component\Proxy\Update;
use Wingu\Engine\SDK\Model\Response\Component\Proxy;
use Wingu\Engine\SDK\Tests\Api\ApiTest;

class ProxyApiTest extends ApiTest
{
    public function testCreateReturnsNewProxyComponent() : void
    {
        $configurationMock = new Configuration();
        $requestFactory    = new GuzzleMessageFactory();
        $hydrator          = new SymfonySerializerHydrator();

        $httpClient = new MockClient();
        $response   = new Response(
            201,
            ['Content-Type' => 'application/json'],
            $this->getDataFromFixturesFile('posted_proxy_component.json')
        );
        $httpClient->addResponse($response);

        $winguApi = new ProxyApi($configurationMock, $httpClient, $requestFactory, $hydrator);

        $actualResponse = $winguApi->create(
            new Create(
                'Proxy payload'
            )
        );

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();
        self::assertSame('{"payload":"Proxy payload"}', $actualRequest->getBody()->getContents());
        self::assertSame('POST', $actualRequest->getMethod());

        $expectedResponse = $this->getExpectedProxy();
        self::assertEquals($expectedResponse, $actualResponse);
    }

    public function testUpdatePatchesProxyComponent() : void
    {
        $configurationMock = new Configuration();
        $requestFactory    = new GuzzleMessageFactory();
        $hydrator          = new SymfonySerializerHydrator();

        $httpClient = new MockClient();
        $response   = new Response(
            204,
            ['Content-Type' => 'application/json']
        );
        $httpClient->addResponse($response);

        $winguApi = new ProxyApi($configurationMock, $httpClient, $requestFactory, $hydrator);

        $winguApi->update(
            '9b762008-8eba-4fe1-b77e-a2f32f23f75f',
            new Update(
                'Proxy payload v2.0'
            )
        );

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();
        self::assertSame('{"payload":"Proxy payload v2.0"}', $actualRequest->getBody()->getContents());
        self::assertSame('PATCH', $actualRequest->getMethod());
    }

    private function getExpectedProxy() : Proxy
    {
        return new Proxy(
            '9b762008-8eba-4fe1-b77e-a2f32f23f75f',
            new \DateTime('2018-09-07T11:42:23+0000'),
            'Proxy payload'
        );
    }
}
