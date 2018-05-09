<?php

declare(strict_types = 1);

namespace Wingu\Engine\SDK\Tests\Api\Channel;

use GuzzleHttp\Psr7\Response;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use Http\Mock\Client as MockClient;
use Speicher210\BusinessHours\BusinessHours;
use Speicher210\BusinessHours\Day\AllDay;
use Speicher210\BusinessHours\Day\Day;
use Speicher210\BusinessHours\Day\Time\TimeInterval;
use Wingu\Engine\SDK\Api\Channel\Channel;
use Wingu\Engine\SDK\Api\Configuration;
use Wingu\Engine\SDK\Hydrator\SymfonySerializerHydrator;
use Wingu\Engine\SDK\Model\Channel\Beacon\PrivateBeacon;
use Wingu\Engine\SDK\Model\Channel\Geofence\Boundaries;
use Wingu\Engine\SDK\Model\Channel\Geofence\PrivateGeofence;
use Wingu\Engine\SDK\Model\Channel\Nfc\PrivateNfc;
use Wingu\Engine\SDK\Model\Channel\QrCode\PrivateQrCode;
use Wingu\Engine\SDK\Tests\Api\ApiTest;

final class ChannelTest extends ApiTest
{
    public function testMyChannelReturnsPrivateBeacon(): void
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

        $winguApi = new Channel($configurationMock, $httpClient, $requestFactory, $hydrator);

        $actual = $winguApi->myChannel('8c798a67-0000-4000-a000-000000000001');
        $expected = $this->getExpectedPrivateBeacon();

        self::assertEquals($expected, $actual);
    }

    public function testMyChannelReturnsPrivateGeofence(): void
    {
        $configurationMock = new Configuration();
        $requestFactory = new GuzzleMessageFactory();
        $hydrator = new SymfonySerializerHydrator();

        $httpClient = new MockClient();
        $httpClient->addResponse(
            new Response(
                200,
                ['Content-Type' => 'application/json'],
                \file_get_contents(__DIR__ . '/Fixtures/full_private_geofence.json')
            )
        );

        $winguApi = new Channel($configurationMock, $httpClient, $requestFactory, $hydrator);

        $actual = $winguApi->myChannel('0a0b190a-0000-4000-a000-000000000001');
        $expected = $this->getExpectedPrivateGeofence();

        self::assertEquals($expected, $actual);
    }

    public function testMyChannelReturnsPrivateNfc(): void
    {
        $configurationMock = new Configuration();
        $requestFactory = new GuzzleMessageFactory();
        $hydrator = new SymfonySerializerHydrator();

        $httpClient = new MockClient();
        $httpClient->addResponse(
            new Response(
                200,
                ['Content-Type' => 'application/json'],
                \file_get_contents(__DIR__ . '/Fixtures/full_private_nfc.json')
            )
        );

        $winguApi = new Channel($configurationMock, $httpClient, $requestFactory, $hydrator);

        $actual = $winguApi->myChannel('44da7d7e-0000-4000-a000-000000000001');
        $expected = $this->getExpectedPrivateNfc();

        self::assertEquals($expected, $actual);
    }

    public function testMyChannelReturnsPrivateQrCode(): void
    {
        $configurationMock = new Configuration();
        $requestFactory = new GuzzleMessageFactory();
        $hydrator = new SymfonySerializerHydrator();

        $httpClient = new MockClient();
        $httpClient->addResponse(
            new Response(
                200,
                ['Content-Type' => 'application/json'],
                \file_get_contents(__DIR__ . '/Fixtures/full_private_qrcode.json')
            )
        );

        $winguApi = new Channel($configurationMock, $httpClient, $requestFactory, $hydrator);

        $actual = $winguApi->myChannel('9a8798c6-0000-4000-a000-000000000001');
        $expected = $this->getExpectedPrivateQrCode();

        self::assertEquals($expected, $actual);
    }

    public function testMyChannelsReturnsResult(): void
    {
        $configurationMock = new Configuration();
        $requestFactory = new GuzzleMessageFactory();
        $hydrator = new SymfonySerializerHydrator();

        $httpClient = new MockClient();
        $httpClient->addResponse(
            new Response(
                200,
                ['Content-Type' => 'application/json'],
                \file_get_contents(__DIR__ . '/Fixtures/full_private_channels.json')
            )
        );

        $channelApi = new Channel($configurationMock, $httpClient, $requestFactory, $hydrator);
        $actual = $channelApi->myChannels();

        $expected = [
            $this->getExpectedPrivateBeacon(),
            $this->getExpectedPrivateNfc(),
            $this->getExpectedPrivateQrCode(),
            $this->getExpectedPrivateGeofence()
        ];

        self::assertCount(4, $actual);
        self::assertEquals($expected, \iterator_to_array($actual));
    }

    public function testMyChannelsReturnsResultAndFetchesNextPages(): void
    {
        $configurationMock = new Configuration();
        $requestFactory = new GuzzleMessageFactory();
        $hydrator = new SymfonySerializerHydrator();

        $httpClient = new MockClient();
        $httpClient->addResponse(
            new Response(
                200,
                ['Content-Type' => 'application/json'],
                \file_get_contents(__DIR__ . '/Fixtures/full_private_channels_paginated_1.json')
            )
        );
        $httpClient->addResponse(
            new Response(
                200,
                ['Content-Type' => 'application/json'],
                \file_get_contents(__DIR__ . '/Fixtures/full_private_channels_paginated_2.json')
            )
        );
        $httpClient->addResponse(
            new Response(
                200,
                ['Content-Type' => 'application/json'],
                \file_get_contents(__DIR__ . '/Fixtures/full_private_channels_paginated_3.json')
            )
        );
        $httpClient->addResponse(
            new Response(
                200,
                ['Content-Type' => 'application/json'],
                \file_get_contents(__DIR__ . '/Fixtures/full_private_channels_paginated_4.json')
            )
        );

        $channelApi = new Channel($configurationMock, $httpClient, $requestFactory, $hydrator);
        $actual = $channelApi->myChannels();

        $expected = [
            $this->getExpectedPrivateBeacon(),
            $this->getExpectedPrivateNfc(),
            $this->getExpectedPrivateQrCode(),
            $this->getExpectedPrivateGeofence()
        ];

        self::assertCount(4, $actual);
        self::assertEquals($expected, \iterator_to_array($actual));
    }

    private function getExpectedPrivateBeacon(): PrivateBeacon
    {
        return new PrivateBeacon(
            '8c798a67-0000-4000-a000-000000000001',
            'Beacon 1100',
            true,
            true,
            null,
            true,
            $this->getExpectedFunctioningHours(),
            '2e422b9f-4955-4f1d-95d1-e57626ad1b26',
            1,
            100
        );
    }

    private function getExpectedPrivateNfc(): PrivateNfc
    {
        return new PrivateNfc(
            '44da7d7e-0000-4000-a000-000000000001',
            'NFC 1',
            true,
            true,
            null,
            false,
            $this->getExpectedFunctioningHours(),
            'https://wingu-sdk-test.de/nfc/d465179f-c30a-423c-a06b-5ce63f6f75ff'
        );
    }

    private function getExpectedPrivateQrCode(): PrivateQrCode
    {
        return new PrivateQrCode(
            '9a8798c6-0000-4000-a000-000000000001',
            'QR 1',
            true,
            true,
            null,
            true,
            $this->getExpectedFunctioningHours(),
            'https://wingu-sdk-test.de/qrcode/7a4b84eb-ae3f-4246-8a67-d16fbdd82595'
        );
    }

    private function getExpectedPrivateGeofence()
    {
        return new PrivateGeofence(
            '0a0b190a-0000-4000-a000-000000000001',
            'Fence 1',
            true,
            true,
            null,
            true,
            $this->getExpectedFunctioningHours(),
            new Boundaries(
                'Polygon',
                [
                    [
                        [9.723595, 53.661423],
                        [9.723595, 53.662321315284],
                        [9.7251110338049, 53.66232130571],
                        [9.7251110338049, 53.661422990426],
                        [9.723595, 53.661423]
                    ]
                ]
            )
        );
    }

    private function getExpectedFunctioningHours(): BusinessHours
    {
        return new BusinessHours(
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
    }
}
