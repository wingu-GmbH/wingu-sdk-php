<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Tests\Api\Channel\Nfc;

use GuzzleHttp\Psr7\Response;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use Http\Mock\Client as MockClient;
use Speicher210\BusinessHours\BusinessHours;
use Speicher210\BusinessHours\Day\AllDay;
use Speicher210\BusinessHours\Day\Day;
use Speicher210\BusinessHours\Day\Time\TimeInterval;
use Wingu\Engine\SDK\Api\Channel\Nfc\NfcApi;
use Wingu\Engine\SDK\Api\Configuration;
use Wingu\Engine\SDK\Hydrator\SymfonySerializerHydrator;
use Wingu\Engine\SDK\Model\Channel\Nfc\PrivateNfc;
use Wingu\Engine\SDK\Model\Channel\Nfc\PublicNfc;
use Wingu\Engine\SDK\Tests\Api\ApiTest;

final class NfcApiTest extends ApiTest
{
    public function testNfcReturnsPublicNfc() : void
    {
        $configurationMock = new Configuration();
        $requestFactory    = new GuzzleMessageFactory();
        $hydrator          = new SymfonySerializerHydrator();

        $httpClient = new MockClient();
        $httpClient->addResponse(
            new Response(
                200,
                ['Content-Type' => 'application/json'],
                \file_get_contents(__DIR__ . '/Fixtures/full_public_nfc.json')
            )
        );

        $winguApi = new NfcApi($configurationMock, $httpClient, $requestFactory, $hydrator);
        $actual   = $winguApi->nfc('9a8798c6-0000-4000-a000-000000000001');

        $expected = new PublicNfc(
            '9a8798c6-0000-4000-a000-000000000001',
            'NFC 1',
            'https://wingu-sdk-test.de/nfc/5ea7f875-7841-48b5-9cce-d9bd1684f87c'
        );

        self::assertEquals($expected, $actual);
    }

    public function testMyNfcReturnsPrivateNfc() : void
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

        $winguApi = new NfcApi($configurationMock, $httpClient, $requestFactory, $hydrator);
        $actual   = $winguApi->myNfc('9a8798c6-0000-4000-a000-000000000002');

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
        $expected                 = new PrivateNfc(
            '9a8798c6-0000-4000-a000-000000000002',
            'Funny Mouse',
            true,
            false,
            'My note',
            false,
            $expectedFunctioningHours,
            'https://wingu-sdk-test.de/nfc/5ea7f875-7841-48b5-9cce-d9bd1684f87c'
        );

        self::assertEquals($expected, $actual);
    }

    public function testPayloadReturnsNfcId() : void
    {
        $configurationMock = new Configuration();
        $requestFactory    = new GuzzleMessageFactory();
        $hydrator          = new SymfonySerializerHydrator();

        $httpClient = new MockClient();
        $httpClient->addResponse(
            new Response(
                200,
                ['Content-Type' => 'application/json'],
                '{"id":"9a8798c6-0000-4000-a000-000000000004"}'
            )
        );

        $winguApi = new NfcApi($configurationMock, $httpClient, $requestFactory, $hydrator);
        $actual   = $winguApi->payload('https://wingu-sdk-test.de/nfc/7a4b84eb-ae3f-4246-8a67-d16fbdd82595');

        self::assertSame('9a8798c6-0000-4000-a000-000000000004', $actual);
    }
}
