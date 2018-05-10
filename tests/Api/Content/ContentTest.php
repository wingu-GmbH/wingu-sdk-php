<?php

declare(strict_types = 1);

namespace Wingu\Engine\SDK\Tests\Api\Content;

use GuzzleHttp\Psr7\Response;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use Http\Mock\Client as MockClient;
use Wingu\Engine\SDK\Api\Configuration;
use Wingu\Engine\SDK\Api\Content\Content;
use Wingu\Engine\SDK\Hydrator\SymfonySerializerHydrator;
use Wingu\Engine\SDK\Model\Card\Card;
use Wingu\Engine\SDK\Model\Card\Position;
use Wingu\Engine\SDK\Model\Content\Deck;
use Wingu\Engine\SDK\Model\Content\Locale;
use Wingu\Engine\SDK\Model\Content\Pack;
use Wingu\Engine\SDK\Model\Content\PrivateContent;
use Wingu\Engine\SDK\Tests\Api\ApiTest;

final class ContentTest extends ApiTest
{
    public function testMyContentReturnsPrivateContent(): void
    {
        $configurationMock = new Configuration();
        $requestFactory = new GuzzleMessageFactory();
        $hydrator = new SymfonySerializerHydrator();

        $httpClient = new MockClient();
        $httpClient->addResponse(
            new Response(
                200,
                ['Content-Type' => 'application/json'],
                \file_get_contents(__DIR__ . '/Fixtures/full_private_content.json')
            )
        );

        $winguApi = new Content($configurationMock, $httpClient, $requestFactory, $hydrator);
        $actual = $winguApi->myContent('12d1da34-0000-4000-a000-000000000001');

        $expected = new PrivateContent(
            '12d1da34-0000-4000-a000-000000000001',
            [
                new Pack(
                    'd6b3b449-1d6b-45d3-94f4-6c736249f474',
                    new Deck(
                        'ea45b0c8-0000-4000-a000-000000000001',
                        'Deck 1 title',
                        'Deck description 1',
                        [
                            new Card('ffa221a0-8a76-40dd-a6db-72be1aa61ec4', new Position(0)),
                            new Card('c00512e8-83f2-453e-adaa-8785936cb881', new Position(1))
                        ]
                    ),
                    new Locale('English', 'en')
                ),
                new Pack(
                    '3564fd0e-b183-4fe8-9f93-ac9f175e447f',
                    new Deck('ea45b0c8-0000-4000-a000-000000000002', 'Deck 2 title', 'Deck description 2', []),
                    new Locale('German', 'de')
                )
            ]
        );

        self::assertEquals($expected, $actual);
    }
}
