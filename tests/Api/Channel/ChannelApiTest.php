<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Tests\Api\Channel;

use GuzzleHttp\Psr7\Response;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use Http\Mock\Client as MockClient;
use Wingu\Engine\SDK\Api\Channel\ChannelApi;
use Wingu\Engine\SDK\Api\Configuration;
use Wingu\Engine\SDK\Hydrator\SymfonySerializerHydrator;
use Wingu\Engine\SDK\Model\Channel\Beacon\BeaconAddress;
use Wingu\Engine\SDK\Model\Channel\Beacon\BeaconLocation;
use Wingu\Engine\SDK\Model\Channel\Beacon\Coordinates;
use Wingu\Engine\SDK\Model\Channel\Beacon\PrivateBeacon;
use Wingu\Engine\SDK\Model\Channel\Geofence\Boundaries;
use Wingu\Engine\SDK\Model\Channel\Geofence\PrivateGeofence;
use Wingu\Engine\SDK\Model\Channel\Nfc\PrivateNfc;
use Wingu\Engine\SDK\Model\Channel\QrCode\PrivateQrCode;
use Wingu\Engine\SDK\Model\Content\PrivateContent;
use Wingu\Engine\SDK\Model\Content\PrivateListContent;
use Wingu\Engine\SDK\Tests\Api\ChannelApiTestCase;

final class ChannelApiTest extends ChannelApiTestCase
{
    public function testMyChannelReturnsPrivateBeacon() : void
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

        $winguApi = new ChannelApi($configurationMock, $httpClient, $requestFactory, $hydrator);

        $actual = $winguApi->myChannel('8c798a67-0000-4000-a000-000000000001');

        $expected = $this->getExpectedPrivateBeacon();
        self::assertEquals($expected, $actual);
    }

    public function testMyChannelReturnsPrivateGeofence() : void
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

        $winguApi = new ChannelApi($configurationMock, $httpClient, $requestFactory, $hydrator);

        $actual   = $winguApi->myChannel('0a0b190a-0000-4000-a000-000000000001');
        $expected = $this->getExpectedPrivateGeofence();

        self::assertEquals($expected, $actual);
    }

    public function testMyChannelReturnsPrivateNfc() : void
    {
        $configurationMock = new Configuration();
        $requestFactory    = new GuzzleMessageFactory();
        $hydrator          = new SymfonySerializerHydrator();

        $httpClient = new MockClient();
        $httpClient->addResponse(
            new Response(
                200,
                ['Content-Type' => 'application/json'],
                \file_get_contents(__DIR__ . '/Fixtures/full_private_nfc.json')
            )
        );

        $winguApi = new ChannelApi($configurationMock, $httpClient, $requestFactory, $hydrator);

        $actual   = $winguApi->myChannel('44da7d7e-0000-4000-a000-000000000001');
        $expected = $this->getExpectedPrivateNfc();

        self::assertEquals($expected, $actual);
    }

    public function testMyChannelReturnsPrivateQrCode() : void
    {
        $configurationMock = new Configuration();
        $requestFactory    = new GuzzleMessageFactory();
        $hydrator          = new SymfonySerializerHydrator();

        $httpClient = new MockClient();
        $httpClient->addResponse(
            new Response(
                200,
                ['Content-Type' => 'application/json'],
                \file_get_contents(__DIR__ . '/Fixtures/full_private_qrcode.json')
            )
        );

        $winguApi = new ChannelApi($configurationMock, $httpClient, $requestFactory, $hydrator);

        $actual   = $winguApi->myChannel('9a8798c6-0000-4000-a000-000000000001');
        $expected = $this->getExpectedPrivateQrCode();

        self::assertEquals($expected, $actual);
    }

    public function testMyChannelsReturnsResult() : void
    {
        $configurationMock = new Configuration();
        $requestFactory    = new GuzzleMessageFactory();
        $hydrator          = new SymfonySerializerHydrator();

        $httpClient = new MockClient();
        $httpClient->addResponse(
            new Response(
                200,
                ['Content-Type' => 'application/json'],
                \file_get_contents(__DIR__ . '/Fixtures/full_private_channels.json')
            )
        );

        $channelApi = new ChannelApi($configurationMock, $httpClient, $requestFactory, $hydrator);
        $actual     = $channelApi->myChannels();

        $expected = [
            $this->getExpectedPrivateListBeacon(),
            $this->getExpectedPrivateListNfc(),
            $this->getExpectedPrivateListQrCode(),
            $this->getExpectedPrivateListGeofence(),
        ];

        self::assertCount(4, $actual);
        self::assertEquals($expected, \iterator_to_array($actual));
    }

    public function testMyChannelsReturnsResultAndFetchesNextPages() : void
    {
        $configurationMock = new Configuration();
        $requestFactory    = new GuzzleMessageFactory();
        $hydrator          = new SymfonySerializerHydrator();

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

        $channelApi = new ChannelApi($configurationMock, $httpClient, $requestFactory, $hydrator);
        $actual     = $channelApi->myChannels();

        $expected = [
            $this->getExpectedPrivateListBeacon(),
            $this->getExpectedPrivateListNfc(),
            $this->getExpectedPrivateListQrCode(),
            $this->getExpectedPrivateListGeofence(),
        ];

        self::assertCount(4, $actual);
        self::assertEquals($expected, \iterator_to_array($actual));
    }

    private function getExpectedPrivateBeacon() : PrivateBeacon
    {
        return new PrivateBeacon(
            '8c798a67-0000-4000-a000-000000000001',
            'Beacon 1100',
            true,
            new PrivateContent('12d1da34-0000-4000-a000-000000000003', []),
            true,
            null,
            true,
            $this->getExpectedFunctioningHours(),
            '2e422b9f-4955-4f1d-95d1-e57626ad1b26',
            1,
            100,
            new BeaconLocation(new Coordinates(9.922292, 53.56581), new BeaconAddress('Germany'))
        );
    }

    private function getExpectedPrivateNfc() : PrivateNfc
    {
        return new PrivateNfc(
            '44da7d7e-0000-4000-a000-000000000001',
            'NFC 1',
            true,
            new PrivateContent('12d1da34-0000-4000-a000-000000000001', []),
            true,
            null,
            false,
            $this->getExpectedFunctioningHours(),
            'https://wingu-sdk-test.de/nfc/d465179f-c30a-423c-a06b-5ce63f6f75ff'
        );
    }

    private function getExpectedPrivateQrCode() : PrivateQrCode
    {
        return new PrivateQrCode(
            '9a8798c6-0000-4000-a000-000000000001',
            'QR 1',
            true,
            new PrivateContent('12d1da34-0000-4000-a000-000000000009', []),
            true,
            null,
            true,
            $this->getExpectedFunctioningHours(),
            'https://wingu-sdk-test.de/qrcode/7a4b84eb-ae3f-4246-8a67-d16fbdd82595'
        );
    }

    private function getExpectedPrivateGeofence() : PrivateGeofence
    {
        return new PrivateGeofence(
            '0a0b190a-0000-4000-a000-000000000001',
            'Fence 1',
            true,
            new PrivateContent('12d1da34-0000-4000-a000-000000000007', []),
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
                        [9.723595, 53.661423],
                    ],
                ]
            )
        );
    }

    private function getExpectedPrivateListBeacon() : PrivateBeacon
    {
        return new PrivateBeacon(
            '8c798a67-0000-4000-a000-000000000001',
            'Beacon 1100',
            true,
            new PrivateListContent('12d1da34-0000-4000-a000-000000000003', 'Deck 1 title'),
            true,
            null,
            true,
            $this->getExpectedFunctioningHours(),
            '2e422b9f-4955-4f1d-95d1-e57626ad1b26',
            1,
            100,
            new BeaconLocation(new Coordinates(9.983716, 53.673348), new BeaconAddress('Germany'))
        );
    }

    private function getExpectedPrivateListNfc() : PrivateNfc
    {
        return new PrivateNfc(
            '44da7d7e-0000-4000-a000-000000000001',
            'NFC 1',
            true,
            new PrivateListContent('12d1da34-0000-4000-a000-000000000001', 'Deck 2 title'),
            true,
            null,
            false,
            $this->getExpectedFunctioningHours(),
            'https://wingu-sdk-test.de/nfc/d465179f-c30a-423c-a06b-5ce63f6f75ff'
        );
    }

    private function getExpectedPrivateListQrCode() : PrivateQrCode
    {
        return new PrivateQrCode(
            '9a8798c6-0000-4000-a000-000000000001',
            'QR 1',
            true,
            new PrivateListContent('12d1da34-0000-4000-a000-000000000009', 'Deck 3 title'),
            true,
            null,
            true,
            $this->getExpectedFunctioningHours(),
            'https://wingu-sdk-test.de/qrcode/7a4b84eb-ae3f-4246-8a67-d16fbdd82595'
        );
    }

    private function getExpectedPrivateListGeofence() : PrivateGeofence
    {
        return new PrivateGeofence(
            '0a0b190a-0000-4000-a000-000000000001',
            'Fence 1',
            true,
            new PrivateListContent('12d1da34-0000-4000-a000-000000000007', 'Deck 4 title'),
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
                        [9.723595, 53.661423],
                    ],
                ]
            )
        );
    }
}
