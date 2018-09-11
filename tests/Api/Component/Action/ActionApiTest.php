<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Tests\Api\Component\Action;

use GuzzleHttp\Psr7\Response;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use Http\Mock\Client as MockClient;
use Psr\Http\Message\RequestInterface;
use Wingu\Engine\SDK\Api\Component\ActionApi;
use Wingu\Engine\SDK\Api\Configuration;
use Wingu\Engine\SDK\Hydrator\SymfonySerializerHydrator;
use Wingu\Engine\SDK\Model\Request\Component\Action\Create;
use Wingu\Engine\SDK\Model\Request\Component\Action\Update;
use Wingu\Engine\SDK\Model\Response\Component\Action;
use Wingu\Engine\SDK\Tests\Api\ApiTest;

class ActionApiTest extends ApiTest
{
    public function testCreateReturnsNewActionComponent() : void
    {
        $configurationMock = new Configuration();
        $requestFactory    = new GuzzleMessageFactory();
        $hydrator          = new SymfonySerializerHydrator();

        $httpClient = new MockClient();
        $response   = new Response(
            201,
            ['Content-Type' => 'application/json'],
            \file_get_contents(__DIR__ . '/Fixtures/posted_action_component.json')
        );
        $httpClient->addResponse($response);

        $winguApi = new ActionApi($configurationMock, $httpClient, $requestFactory, $hydrator);

        $actualResponse = $winguApi->create(
            new Create(
                'click me',
                'open-url',
                'https://www.wingu.de'
            )
        );

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();
        self::assertSame(
            '{"buttonCaption":"click me","actionType":"open-url","actionPayload":"https:\/\/www.wingu.de"}',
            $actualRequest->getBody()->getContents()
        );
        self::assertSame('POST', $actualRequest->getMethod());

        $expectedResponse = $this->getExpectedAction();
        self::assertEquals($expectedResponse, $actualResponse);
    }

    public function testUpdatePatchesActionComponent() : void
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

        $winguApi = new ActionApi($configurationMock, $httpClient, $requestFactory, $hydrator);

        $winguApi->update(
            'ea0226b8-d6a2-4f20-a3a2-d4db7485bc32',
            new Update(
                'edited me',
                null,
                null
            )
        );

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();
        self::assertSame('{"buttonCaption":"edited me","actionType":null,"actionPayload":null}', $actualRequest->getBody()->getContents());
        self::assertSame('PATCH', $actualRequest->getMethod());
    }

    private function getExpectedAction() : Action
    {
        return new Action(
            'ea0226b8-d6a2-4f20-a3a2-d4db7485bc32',
            new \DateTime('2018-09-05T10:56:48+0000'),
            'click me',
            'open-url',
            'https://www.wingu.de'
        );
    }
}
