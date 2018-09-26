<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Tests\Api\Component\Separator;

use GuzzleHttp\Psr7\Response;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use Http\Mock\Client as MockClient;
use Psr\Http\Message\RequestInterface;
use Wingu\Engine\SDK\Api\Component\SeparatorApi;
use Wingu\Engine\SDK\Api\Configuration;
use Wingu\Engine\SDK\Hydrator\SymfonySerializerHydrator;
use Wingu\Engine\SDK\Model\Request\Component\Separator\Create;
use Wingu\Engine\SDK\Model\Request\Component\Separator\Update;
use Wingu\Engine\SDK\Model\Response\Component\Separator;
use Wingu\Engine\SDK\Tests\Api\ApiTest;

class SeparatorApiTest extends ApiTest
{
    public function testCreateReturnsNewSeparatorComponent() : void
    {
        $configurationMock = new Configuration();
        $requestFactory    = new GuzzleMessageFactory();
        $hydrator          = new SymfonySerializerHydrator();

        $httpClient = new MockClient();
        $response   = new Response(
            201,
            ['Content-Type' => 'application/json'],
            $this->getDataFromFixturesFile('posted_separator_component.json')
        );
        $httpClient->addResponse($response);

        $winguApi = new SeparatorApi($configurationMock, $httpClient, $requestFactory, $hydrator);

        $actualResponse = $winguApi->create(
            new Create(
                'wave',
                '04b1f0'
            )
        );

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();
        self::assertSame('{"type":"wave","colorHex":"04b1f0"}', $actualRequest->getBody()->getContents());
        self::assertSame('POST', $actualRequest->getMethod());

        $expectedResponse = $this->getExpectedSeparator();
        self::assertEquals($expectedResponse, $actualResponse);
    }

    public function testUpdatePatchesSeparatorComponent() : void
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

        $winguApi = new SeparatorApi($configurationMock, $httpClient, $requestFactory, $hydrator);

        $winguApi->update(
            '28ebe9e5-53a4-41d2-8e3b-f8d8a442ae34',
            new Update(
                'dots',
                '04b1f0'
            )
        );

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();
        self::assertSame('{"type":"dots","colorHex":"04b1f0"}', $actualRequest->getBody()->getContents());
        self::assertSame('PATCH', $actualRequest->getMethod());
    }

    private function getExpectedSeparator() : Separator
    {
        return new Separator(
            '28ebe9e5-53a4-41d2-8e3b-f8d8a442ae34',
            new \DateTime('2018-09-07T11:49:07+0000'),
            'wave',
            '04b1f0'
        );
    }
}
