<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Tests\Api\Channel;

use GuzzleHttp\Psr7\Response;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use Http\Mock\Client as MockClient;
use Wingu\Engine\SDK\Api\Channel\ChannelApi;
use Wingu\Engine\SDK\Api\Configuration;
use Wingu\Engine\SDK\Api\Exception\HttpClient\NotFound;
use Wingu\Engine\SDK\Hydrator\SymfonySerializerHydrator;
use Wingu\Engine\SDK\Model\Request\Channel\PrivateChannelsFilter;
use Wingu\Engine\SDK\Model\Request\Channel\PrivateChannelsSorting;
use Wingu\Engine\SDK\Model\Request\PaginationParameters;
use Wingu\Engine\SDK\Model\Request\RequestParameters;
use Wingu\Engine\SDK\Model\Response\Channel\Beacon\BeaconAddress;
use Wingu\Engine\SDK\Model\Response\Channel\Beacon\BeaconLocation;
use Wingu\Engine\SDK\Model\Response\Channel\Beacon\Coordinates;
use Wingu\Engine\SDK\Model\Response\Channel\Beacon\PrivateBeacon;
use Wingu\Engine\SDK\Model\Response\Channel\Geofence\Boundaries;
use Wingu\Engine\SDK\Model\Response\Channel\Geofence\PrivateGeofence;
use Wingu\Engine\SDK\Model\Response\Channel\Nfc\PrivateNfc;
use Wingu\Engine\SDK\Model\Response\Channel\QrCode\PrivateQrCode;
use Wingu\Engine\SDK\Model\Response\Content\PrivateContent;
use Wingu\Engine\SDK\Model\Response\Content\PrivateListContent;
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

    public function testMyChannelsWithFiltersReturnsFilteredResult() : void
    {
        $configurationMock = new Configuration();
        $requestFactory    = new GuzzleMessageFactory();
        $hydrator          = new SymfonySerializerHydrator();

        $httpClient = new MockClient();
        $httpClient->addResponse(
            new Response(
                200,
                ['Content-Type' => 'application/json'],
                \file_get_contents(__DIR__ . '/Fixtures/full_private_channels_filtered.json')
            )
        );

        $channelApi = new ChannelApi($configurationMock, $httpClient, $requestFactory, $hydrator);
        // beacons with content attached
        $actual = $channelApi->myChannels(new PrivateChannelsFilter(null, null, 'beacon', null, null, null, true));

        $expected = [
            $this->getExpectedFilteredBeacon1(),
            $this->getExpectedFilteredBeacon2(),
            $this->getExpectedFilteredBeacon3(),
        ];

        self::assertCount(3, $actual);
        self::assertEquals($expected, \iterator_to_array($actual));
    }

    public function testMyChannelsWithSortingReturnsSortedResult() : void
    {
        $configurationMock = new Configuration();
        $requestFactory    = new GuzzleMessageFactory();
        $hydrator          = new SymfonySerializerHydrator();

        $httpClient = new MockClient();
        $httpClient->addResponse(
            new Response(
                200,
                ['Content-Type' => 'application/json'],
                \file_get_contents(__DIR__ . '/Fixtures/full_private_channels_sorted.json')
            )
        );

        $channelApi = new ChannelApi($configurationMock, $httpClient, $requestFactory, $hydrator);
        $actual     = $channelApi->myChannels(null, new PrivateChannelsSorting(RequestParameters::SORTING_ORDER_DESC));

        $expected = [
            $this->getExpectedSortedChannel1(),
            $this->getExpectedSortedChannel2(),
            $this->getExpectedSortedChannel3(),
        ];

        self::assertCount(3, $actual);
        self::assertEquals($expected, \iterator_to_array($actual));
    }

    public function testMyChannelsPageReturnsPageWithChannelsEmbedded() : void
    {
        $configurationMock = new Configuration();
        $requestFactory    = new GuzzleMessageFactory();
        $hydrator          = new SymfonySerializerHydrator();

        $httpClient = new MockClient();
        $httpClient->addResponse(
            new Response(
                200,
                ['Content-Type' => 'application/json'],
                \file_get_contents(__DIR__ . '/Fixtures/full_private_channels_page.json')
            )
        );

        $channelApi     = new ChannelApi($configurationMock, $httpClient, $requestFactory, $hydrator);
        $actual         = $channelApi->myChannelsPage(new PaginationParameters(2, 4));
        $actualChannels = $actual->embedded();

        $expectedChannels = [
            $this->getExpectedPrivateListBeacon(),
            $this->getExpectedPrivateListNfc(),
            $this->getExpectedPrivateListQrCode(),
            $this->getExpectedPrivateListGeofence(),
        ];
        self::assertCount(4, $actualChannels);
        self::assertEquals($expectedChannels, $actualChannels);

        $actualPageInfo = $actual->pageInfo();

        self::assertTrue($actualPageInfo->hasNextPage());
        self::assertSame(2, $actualPageInfo->page());
        self::assertSame(4, $actualPageInfo->limit());
        self::assertSame(3, $actualPageInfo->pages());
        self::assertSame(9, $actualPageInfo->total());
    }

    public function testMyChannelsPageWithWithFiltersReturnsFilteredResult() : void
    {
        $configurationMock = new Configuration();
        $requestFactory    = new GuzzleMessageFactory();
        $hydrator          = new SymfonySerializerHydrator();

        $httpClient = new MockClient();
        $httpClient->addResponse(
            new Response(
                200,
                ['Content-Type' => 'application/json'],
                \file_get_contents(__DIR__ . '/Fixtures/full_private_channels_page_filtered.json')
            )
        );

        $channelApi     = new ChannelApi($configurationMock, $httpClient, $requestFactory, $hydrator);
        $actual         = $channelApi->myChannelsPage(
            new PaginationParameters(2, 3),
            new PrivateChannelsFilter(null, null, 'beacon', null, null, null, true)
        );
        $actualChannels = $actual->embedded();

        $expectedChannels = [
            $this->getExpectedFilteredNfc1(),
            $this->getExpectedFilteredNfc2(),
            $this->getExpectedFilteredNfc3(),
        ];

        self::assertCount(3, $actualChannels);
        self::assertEquals($expectedChannels, $actualChannels);

        $actualPageInfo = $actual->pageInfo();

        self::assertTrue($actualPageInfo->hasNextPage());
        self::assertSame(2, $actualPageInfo->page());
        self::assertSame(3, $actualPageInfo->limit());
        self::assertSame(4, $actualPageInfo->pages());
        self::assertSame(10, $actualPageInfo->total());
    }

    public function testMyChannelsPageWithSortingReturnsSortedResult() : void
    {
        $configurationMock = new Configuration();
        $requestFactory    = new GuzzleMessageFactory();
        $hydrator          = new SymfonySerializerHydrator();

        $httpClient = new MockClient();
        $httpClient->addResponse(
            new Response(
                200,
                ['Content-Type' => 'application/json'],
                \file_get_contents(__DIR__ . '/Fixtures/full_private_channels_page_sorted.json')
            )
        );

        $channelApi     = new ChannelApi($configurationMock, $httpClient, $requestFactory, $hydrator);
        $actual         = $channelApi->myChannelsPage(
            new PaginationParameters(2, 3),
            null,
            new PrivateChannelsSorting(null, RequestParameters::SORTING_ORDER_DESC)
        );
        $actualChannels = $actual->embedded();

        $expectedChannels = [
            $this->getExpectedSortedChannelFromSecondPage1(),
            $this->getExpectedSortedChannelFromSecondPage2(),
            $this->getExpectedSortedChannelFromSecondPage3(),
        ];

        self::assertCount(3, $actualChannels);
        self::assertEquals($expectedChannels, $actualChannels);

        $actualPageInfo = $actual->pageInfo();

        self::assertTrue($actualPageInfo->hasNextPage());
        self::assertSame(2, $actualPageInfo->page());
        self::assertSame(3, $actualPageInfo->limit());
        self::assertSame(46, $actualPageInfo->pages());
        self::assertSame(137, $actualPageInfo->total());
    }

    public function testMyChannelsPageThrowsExceptionWhenPageIsNotFound() : void
    {
        $configurationMock = new Configuration();
        $requestFactory    = new GuzzleMessageFactory();
        $hydrator          = new SymfonySerializerHydrator();
        $httpClient        = new MockClient();
        $httpClient->addResponse(new Response(
            404
        ));
//        $httpClient->addResponse(new NotFound())

        $channelApi = new ChannelApi($configurationMock, $httpClient, $requestFactory, $hydrator);

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('Resource not found.');

        $channelApi->myChannelsPage(new PaginationParameters(999, 10));
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

    private function getExpectedFilteredBeacon1() : PrivateBeacon
    {
        return new PrivateBeacon(
            '44d8d1f7-fb01-488a-8c45-c8a8c07b265a',
            'Beacon 1',
            true,
            new PrivateListContent('12d1da34-0000-4000-a000-000000000009', 'Deck 9 title'),
            true,
            null,
            true,
            null,
            '3f104004-b288-4501-80c2-4ac30a02355b',
            1,
            1,
            new BeaconLocation(null, new BeaconAddress(null))
        );
    }

    private function getExpectedFilteredBeacon2() : PrivateBeacon
    {
        return new PrivateBeacon(
            '6075909e-1605-4ede-8754-cd07257b6826',
            'Beacon 3',
            true,
            new PrivateListContent('12d1da34-0000-4000-a000-000000000007', 'Deck 7 title'),
            true,
            null,
            true,
            null,
            '3f104004-b288-4501-80c2-4ac30a02355b',
            3,
            3,
            new BeaconLocation(null, new BeaconAddress(null))
        );
    }

    private function getExpectedFilteredBeacon3() : PrivateBeacon
    {
        return new PrivateBeacon(
            '7a9d69c2-651c-48aa-ab9a-701c2fac2392',
            'Beacon 2',
            true,
            new PrivateListContent('12d1da34-0000-4000-a000-000000000002', 'Deck 2 title'),
            true,
            null,
            true,
            null,
            '3f104004-b288-4501-80c2-4ac30a02355b',
            2,
            2,
            new BeaconLocation(null, new BeaconAddress(null))
        );
    }

    private function getExpectedSortedChannel1() : PrivateQrCode
    {
        return new PrivateQrCode(
            '9a8798c6-0000-4000-a000-000000000010',
            'QR 10',
            true,
            new PrivateListContent('12d1da34-0000-4000-a000-000000000002', 'Deck 2 title'),
            true,
            null,
            true,
            null,
            'https://wingu-sdk-test.de/qrcode/33d6f4c2-759b-4a81-b800-686430118729'
        );
    }

    private function getExpectedSortedChannel2() : PrivateQrCode
    {
        return new PrivateQrCode(
            '9a8798c6-0000-4000-a000-000000000009',
            'QR 9',
            true,
            new PrivateListContent('12d1da34-0000-4000-a000-000000000009', 'Deck 9 title'),
            true,
            null,
            true,
            null,
            'https://wingu-sdk-test.de/qrcode/5dbe060a-7d0a-43bf-a025-2a7bacedc1f7'
        );
    }

    private function getExpectedSortedChannel3() : PrivateQrCode
    {
        return new PrivateQrCode(
            '9a8798c6-0000-4000-a000-000000000008',
            'QR 8',
            true,
            new PrivateListContent('12d1da34-0000-4000-a000-000000000002', 'Deck 2 title'),
            true,
            null,
            true,
            null,
            'https://wingu-sdk-test.de/qrcode/b9a5abd6-4156-4bb9-a4e0-58a19e6c95f4'
        );
    }

    private function getExpectedFilteredNfc1() : PrivateNfc
    {
        return new PrivateNfc(
            '44da7d7e-0000-4000-a000-000000000004',
            'NFC 4',
            true,
            new PrivateListContent(
                '12d1da34-0000-4000-a000-000000000002',
                'Deck 2 title'
            ),
            true,
            null,
            true,
            null,
            'https://wingu-sdk-test.de/nfc/f9ee97b4-3b18-43fd-9264-aa368fd4cae3'
        );
    }

    private function getExpectedFilteredNfc2() : PrivateNfc
    {
        return new PrivateNfc(
            '44da7d7e-0000-4000-a000-000000000005',
            'NFC 5',
            true,
            new PrivateListContent(
                '12d1da34-0000-4000-a000-000000000010',
                'Deck 10 title'
            ),
            true,
            null,
            true,
            null,
            'https://wingu-sdk-test.de/nfc/d36c3333-35b9-43f2-9c75-ff5710d70494'
        );
    }

    private function getExpectedFilteredNfc3() : PrivateNfc
    {
        return new PrivateNfc(
            '44da7d7e-0000-4000-a000-000000000006',
            'NFC 6',
            true,
            new PrivateListContent(
                '12d1da34-0000-4000-a000-000000000003',
                'Deck 3 title'
            ),
            true,
            null,
            true,
            null,
            'https://wingu-sdk-test.de/nfc/adb93329-e7d2-4197-ad3b-e6ea3baaf202'
        );
    }

    private function getExpectedSortedChannelFromSecondPage1() : PrivateQrCode
    {
        return new PrivateQrCode(
            '9a8798c6-0000-4000-a000-000000000006',
            'QR 6',
            true,
            new PrivateListContent(
                '12d1da34-0000-4000-a000-000000000006',
                'Deck 6 title'
            ),
            true,
            null,
            true,
            null,
            'https://wingu-sdk-test.de/qrcode/6bfbc8d8-b2ef-465a-becf-4554192d33c3'
        );
    }

    private function getExpectedSortedChannelFromSecondPage2() : PrivateQrCode
    {
        return new PrivateQrCode(
            '9a8798c6-0000-4000-a000-000000000005',
            'QR 5',
            true,
            new PrivateListContent(
                '12d1da34-0000-4000-a000-000000000005',
                'Deck 5 title'
            ),
            true,
            null,
            true,
            null,
            'https://wingu-sdk-test.de/qrcode/4d28241d-cbfd-488c-a3a6-5695b19db740'
        );
    }

    private function getExpectedSortedChannelFromSecondPage3() : PrivateQrCode
    {
        return new PrivateQrCode(
            '9a8798c6-0000-4000-a000-000000000004',
            'QR 4',
            true,
            new PrivateListContent(
                '12d1da34-0000-4000-a000-000000000001',
                'Deck 1 title'
            ),
            true,
            null,
            true,
            null,
            'https://wingu-sdk-test.de/qrcode/04d8873c-8758-49eb-ba95-6146366f1d58'
        );
    }
}
