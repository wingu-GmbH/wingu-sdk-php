<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Tests\Api\Channel\Geofence;

use GuzzleHttp\Psr7\Response;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use Http\Mock\Client as MockClient;
use Speicher210\BusinessHours\BusinessHours;
use Speicher210\BusinessHours\Day\AllDay;
use Speicher210\BusinessHours\Day\Day;
use Speicher210\BusinessHours\Day\Time\TimeInterval;
use Wingu\Engine\SDK\Api\Channel\Geofence\GeofenceApi;
use Wingu\Engine\SDK\Api\Configuration;
use Wingu\Engine\SDK\Hydrator\SymfonySerializerHydrator;
use Wingu\Engine\SDK\Model\Channel\Geofence\Boundaries;
use Wingu\Engine\SDK\Model\Channel\Geofence\PrivateGeofence;
use Wingu\Engine\SDK\Model\Channel\Geofence\PublicGeofence;
use Wingu\Engine\SDK\Tests\Api\ApiTest;

final class GeofenceApiTest extends ApiTest
{
    public function testGeofenceReturnsPublicGeofence() : void
    {
        $configurationMock = new Configuration();
        $requestFactory    = new GuzzleMessageFactory();
        $hydrator          = new SymfonySerializerHydrator();

        $httpClient = new MockClient();
        $httpClient->addResponse(
            new Response(
                200,
                ['Content-Type' => 'application/json'],
                \file_get_contents(__DIR__ . '/Fixtures/full_public_geofence.json')
            )
        );

        $winguApi = new GeofenceApi($configurationMock, $httpClient, $requestFactory, $hydrator);
        $actual   = $winguApi->geofence('0a0b190a-0000-4000-a000-000000000001');

        $expected = new PublicGeofence(
            '0a0b190a-0000-4000-a000-000000000001',
            'Geofence 1',
            new Boundaries(
                'Polygon',
                [
                    [
                        [9.723595, 53.661423],
                        [9.723595, 53.662321315284],
                        [9.7251110338049, 53.66232130571],
                        [9.7251110338049, 53.661422990426],
                        [9.723595, 53.661423],
                    ],
                ]
            )
        );

        self::assertEquals($expected, $actual);
    }

    public function testMyGeofenceReturnsPrivateGeofence() : void
    {
        $configurationMock = new Configuration();
        $requestFactory    = new GuzzleMessageFactory();
        $hydrator          = new SymfonySerializerHydrator();

        $httpClient = new MockClient();
        $httpClient->addResponse(
            new Response(
                200,
                ['Content-Type' => 'application/json'],
                \file_get_contents(__DIR__ . '/Fixtures/full_private_geofence.json')
            )
        );

        $winguApi = new GeofenceApi($configurationMock, $httpClient, $requestFactory, $hydrator);
        $actual   = $winguApi->myGeofence('0a0b190a-0000-4000-a000-000000000001');

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

        $expected = new PrivateGeofence(
            '0a0b190a-0000-4000-a000-000000000001',
            'Funny Rabbit',
            true,
            false,
            'My note',
            false,
            $expectedFunctioningHours,
            new Boundaries(
                'Polygon',
                [
                    [
                        [9.723595, 53.661423],
                        [9.723595, 53.662321315284],
                        [9.7251110338049, 53.66232130571],
                        [9.7251110338049, 53.661422990426],
                        [9.723595, 53.661423],
                    ],
                ]
            )
        );

        self::assertEquals($expected, $actual);
    }
}
