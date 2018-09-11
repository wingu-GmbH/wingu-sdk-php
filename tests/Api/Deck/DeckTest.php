<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Tests\Api\Deck;

use GuzzleHttp\Psr7\Response;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use Http\Mock\Client as MockClient;
use Psr\Http\Message\RequestInterface;
use Wingu\Engine\SDK\Api\Configuration;
use Wingu\Engine\SDK\Api\Deck as DeckApi;
use Wingu\Engine\SDK\Hydrator\SymfonySerializerHydrator;
use Wingu\Engine\SDK\Model\Request\Deck\Deck as RequestDeck;
use Wingu\Engine\SDK\Model\Response\Content\Deck as ResponseDeck;
use Wingu\Engine\SDK\Tests\Api\ApiTest;

final class DeckTest extends ApiTest
{
    public function testPostDeckCreatesDeck() : void
    {
        $configurationMock = new Configuration();
        $requestFactory    = new GuzzleMessageFactory();
        $hydrator          = new SymfonySerializerHydrator();

        $httpClient = new MockClient();
        $response   = new Response(
            201,
            ['Content-Type' => 'application/json'],
            \file_get_contents(__DIR__ . '/Fixtures/posted_deck.json')
        );
        $httpClient->addResponse($response);

        $winguApi = new DeckApi($configurationMock, $httpClient, $requestFactory, $hydrator);

        $actualResponse = $winguApi->createDeck(
            new RequestDeck(
                'My new deck',
                'Description of my new deck',
                null
            )
        );

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();
        self::assertSame('{"title":"My new deck","description":"Description of my new deck","legalNote":null}', $actualRequest->getBody()->getContents());
        self::assertSame('POST', $actualRequest->getMethod());

        $expectedResponse = $this->getExpectedPostedDeck();
        self::assertEquals($expectedResponse, $actualResponse);
    }

    public function testDeleteMyCardRemovesPrivateDeck() : void
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

        $winguApi = new DeckApi($configurationMock, $httpClient, $requestFactory, $hydrator);

        $winguApi->deleteMyDeck('ea45b0c8-0000-4000-a000-000000000010');

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();
        self::assertSame('', $actualRequest->getBody()->getContents());
        self::assertSame('DELETE', $actualRequest->getMethod());
    }

    private function getExpectedPostedDeck() : ResponseDeck
    {
        return new ResponseDeck(
            '1e4bfb95-87d6-4070-b9cd-a85681595f62',
            'My new deck',
            'Description of my new deck',
            []
        );
    }
}
