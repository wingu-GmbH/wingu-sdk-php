<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Tests\Api\Channel\Beacon;

use GuzzleHttp\Psr7\Response;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use Http\Mock\Client as MockClient;
use Speicher210\BusinessHours\BusinessHours;
use Speicher210\BusinessHours\Day\AllDay;
use Speicher210\BusinessHours\Day\Day;
use Speicher210\BusinessHours\Day\Time\TimeInterval;
use Wingu\Engine\SDK\Api\Channel\Beacon\BeaconApi;
use Wingu\Engine\SDK\Api\Configuration;
use Wingu\Engine\SDK\Hydrator\SymfonySerializerHydrator;
use Wingu\Engine\SDK\Model\Card\Card;
use Wingu\Engine\SDK\Model\Card\Position;
use Wingu\Engine\SDK\Model\Channel\Beacon\PrivateBeacon;
use Wingu\Engine\SDK\Model\Channel\Beacon\PublicBeacon;
use Wingu\Engine\SDK\Model\Content\Category;
use Wingu\Engine\SDK\Model\Content\Deck;
use Wingu\Engine\SDK\Model\Content\Locale;
use Wingu\Engine\SDK\Model\Content\Pack;
use Wingu\Engine\SDK\Model\Content\PublicContent;
use Wingu\Engine\SDK\Tests\Api\ApiTest;

final class BeaconApiTest extends ApiTest
{
    public function testBeaconReturnsPublicBeacon() : void
    {
        $configurationMock = new Configuration();
        $requestFactory    = new GuzzleMessageFactory();
        $hydrator          = new SymfonySerializerHydrator();

        $httpClient = new MockClient();
        $httpClient->addResponse(
            new Response(
                200,
                ['Content-Type' => 'application/json'],
                \file_get_contents(__DIR__ . '/Fixtures/full_public_beacon.json')
            )
        );

        $winguApi = new BeaconApi($configurationMock, $httpClient, $requestFactory, $hydrator);
        $actual   = $winguApi->beacon('02a554ab-34bc-48b7-87ad-754037b8b09b');

        $expected = new PublicBeacon(
            '02a554ab-34bc-48b7-87ad-754037b8b09b',
            'Beacon 1',
            '3f104004-b288-4501-80c2-4ac30a02355b',
            1,
            2,
            new PublicContent(
                '12d1da34-0000-4000-a000-000000000019',
                new Category(6, 'Entertainment', '00B7AE'),
                new Pack(
                    '71400bb6-c593-43f6-809f-5fafc4445c9b',
                    new Deck(
                        'ea45b0c8-0000-4000-a000-000000000019',
                        'Deck title',
                        'Deck description',
                        [
                            new Card('d6ac7466-c37f-4f0c-af09-cbcebffcbd3a', new Position(0)),
                            new Card('8be641f3-987d-4955-b127-dd1fe441bdc3', new Position(1)),
                            new Card('9f569272-0a16-4d2d-8fb3-8ebf9b42f294', new Position(2)),
                            new Card('4a4ad94f-e439-4777-a11e-b339c0c62e77', new Position(3)),
                            new Card('d96431b3-156b-4f1e-b173-4e646ad29a75', new Position(4)),
                            new Card('710af718-5216-457d-859c-55096fdb56e9', new Position(5)),
                            new Card('8219d906-8977-4719-a73d-aedc80ea106b', new Position(6)),
                            new Card('33524d58-793f-47e0-a94b-78ff364a88bb', new Position(7)),
                            new Card('a61c1903-1cba-45ca-afb6-8d61e6c061a8', new Position(8)),
                            new Card('cbe5b575-4af6-4350-a914-b5f78e534810', new Position(9)),
                            new Card('b87af441-e01d-4c5a-b9e2-a2d8b874f2e3', new Position(10)),
                            new Card('fe80808f-7034-4bcd-a33e-79907dffdcc5', new Position(11)),
                            new Card('a8fd644e-119e-47b9-9086-ba79f04680ac', new Position(12)),
                            new Card('5b64dce4-4fc6-48d3-9353-f9f7d0742343', new Position(13)),
                        ]
                    ),
                    new Locale('English', 'en')
                )
            )
        );

        self::assertEquals($expected, $actual);
    }

    public function testMyBeaconReturnsPrivateBeacon() : void
    {
        $configurationMock = new Configuration();
        $requestFactory    = new GuzzleMessageFactory();
        $hydrator          = new SymfonySerializerHydrator();

        $httpClient = new MockClient();
        $httpClient->addResponse(
            new Response(
                200,
                ['Content-Type' => 'application/json'],
                \file_get_contents(__DIR__ . '/Fixtures/full_private_beacon.json')
            )
        );

        $winguApi = new BeaconApi($configurationMock, $httpClient, $requestFactory, $hydrator);
        $actual   = $winguApi->myBeacon('9616c673-b24f-4445-872c-4851e1790731');

        $expectedFunctioningHours = new BusinessHours(
            [
                new AllDay(Day::WEEK_DAY_MONDAY),
                new Day(
                    Day::WEEK_DAY_WEDNESDAY,
                    [
                        TimeInterval::fromString('08:00', '12:00'),
                        TimeInterval::fromString('13:00', '18:00'),
                    ]
                ),
                new AllDay(Day::WEEK_DAY_FRIDAY),
            ],
            new \DateTimeZone('Europe/Berlin')
        );

        $expected = new PrivateBeacon(
            '9616c673-b24f-4445-872c-4851e1790731',
            'Funny Dog',
            true,
            false,
            'My note',
            false,
            $expectedFunctioningHours,
            '3f104004-b288-4501-80c2-4ac30a02355b',
            1,
            3
        );

        self::assertEquals($expected, $actual);
    }

    public function testEddystoneReturnsBeaconId() : void
    {
        $configurationMock = new Configuration();
        $requestFactory    = new GuzzleMessageFactory();
        $hydrator          = new SymfonySerializerHydrator();

        $httpClient = new MockClient();
        $httpClient->addResponse(
            new Response(
                200,
                ['Content-Type' => 'application/json'],
                '{"id":"8c798a67-0000-4000-a000-000000000017"}'
            )
        );

        $winguApi = new BeaconApi($configurationMock, $httpClient, $requestFactory, $hydrator);
        $actual   = $winguApi->eddystone('https://wingu-sdk-test.de/78d9c5a7-18e2-4039-bd58-e8c608c3290a');

        self::assertSame('8c798a67-0000-4000-a000-000000000017', $actual);
    }
}
