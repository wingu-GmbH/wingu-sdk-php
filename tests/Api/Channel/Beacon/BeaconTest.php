<?php

declare(strict_types = 1);

namespace Wingu\Engine\SDK\Tests\Api\Channel\Beacon;

use GuzzleHttp\Psr7\Response;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use Http\Mock\Client as MockClient;
use Speicher210\BusinessHours\BusinessHours;
use Speicher210\BusinessHours\Day\AllDay;
use Speicher210\BusinessHours\Day\Day;
use Speicher210\BusinessHours\Day\Time\TimeInterval;
use Wingu\Engine\SDK\Api\Channel\Beacon\Beacon;
use Wingu\Engine\SDK\Api\Configuration;
use Wingu\Engine\SDK\Hydrator\SymfonySerializerHydrator;
use Wingu\Engine\SDK\Model\Channel\Beacon\PrivateBeacon;
use Wingu\Engine\SDK\Model\Channel\Beacon\PublicBeacon;
use Wingu\Engine\SDK\Tests\Api\ApiTest;

final class BeaconTest extends ApiTest
{
    public function testBeaconReturnsPublicBeacon(): void
    {
        $configurationMock = new Configuration();
        $requestFactory = new GuzzleMessageFactory();
        $hydrator = new SymfonySerializerHydrator();

        $httpClient = new MockClient();
        $httpClient->addResponse(
            new Response(
                200,
                ['Content-Type' => 'application/json'],
                \file_get_contents(__DIR__ . '/Fixtures/full_public_beacon.json')
            )
        );

        $winguApi = new Beacon($configurationMock, $httpClient, $requestFactory, $hydrator);
        $actual = $winguApi->beacon('02a554ab-34bc-48b7-87ad-754037b8b09b');

        $expected = new PublicBeacon(
            '02a554ab-34bc-48b7-87ad-754037b8b09b',
            'Beacon 1',
            '3f104004-b288-4501-80c2-4ac30a02355b',
            1,
            2
        );

        self::assertEquals($expected, $actual);

        self::markTestIncomplete('Denormalize a full beacon. Including content, packs, cards, etc.');
    }

    public function testMyBeaconReturnsPrivateBeacon(): void
    {
        $configurationMock = new Configuration();
        $requestFactory = new GuzzleMessageFactory();
        $hydrator = new SymfonySerializerHydrator();

        $httpClient = new MockClient();
        $httpClient->addResponse(
            new Response(
                200,
                ['Content-Type' => 'application/json'],
                \file_get_contents(__DIR__ . '/Fixtures/full_private_beacon.json')
            )
        );

        $winguApi = new Beacon($configurationMock, $httpClient, $requestFactory, $hydrator);
        $actual = $winguApi->myBeacon('9616c673-b24f-4445-872c-4851e1790731');

        $expectedFunctioningHours = new BusinessHours(
            [
                new AllDay(Day::WEEK_DAY_MONDAY),
                new Day(
                    Day::WEEK_DAY_WEDNESDAY,
                    [
                        TimeInterval::fromString('08:00', '12:00'),
                        TimeInterval::fromString('13:00', '18:00')
                    ]
                ),
                new AllDay(Day::WEEK_DAY_FRIDAY)
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

        self::markTestIncomplete('Denormalize a full beacon. Including content, packs, cards, etc.');
    }
}
