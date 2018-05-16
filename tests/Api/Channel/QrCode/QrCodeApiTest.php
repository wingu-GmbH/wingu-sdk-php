<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Tests\Api\Channel\QrCode;

use GuzzleHttp\Psr7\Response;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use Http\Mock\Client as MockClient;
use Speicher210\BusinessHours\BusinessHours;
use Speicher210\BusinessHours\Day\AllDay;
use Speicher210\BusinessHours\Day\Day;
use Speicher210\BusinessHours\Day\Time\TimeInterval;
use Wingu\Engine\SDK\Api\Channel\QrCode\QrCodeApi;
use Wingu\Engine\SDK\Api\Configuration;
use Wingu\Engine\SDK\Hydrator\SymfonySerializerHydrator;
use Wingu\Engine\SDK\Model\Channel\QrCode\PrivateQrCode;
use Wingu\Engine\SDK\Model\Channel\QrCode\PublicQrCode;
use Wingu\Engine\SDK\Tests\Api\ApiTest;

final class QrCodeApiTest extends ApiTest
{
    public function testQrCodeReturnsPublicQrCode() : void
    {
        $configurationMock = new Configuration();
        $requestFactory    = new GuzzleMessageFactory();
        $hydrator          = new SymfonySerializerHydrator();

        $httpClient = new MockClient();
        $httpClient->addResponse(
            new Response(
                200,
                ['Content-Type' => 'application/json'],
                \file_get_contents(__DIR__ . '/Fixtures/full_public_qrcode.json')
            )
        );

        $winguApi = new QrCodeApi($configurationMock, $httpClient, $requestFactory, $hydrator);
        $actual   = $winguApi->qrCode('9a8798c6-0000-4000-a000-000000000001');

        $expected = new PublicQrCode(
            '9a8798c6-0000-4000-a000-000000000001',
            'QR 1',
            'https://wingu-sdk-test.de/qrcode/7a4b84eb-ae3f-4246-8a67-d16fbdd82595'
        );

        self::assertEquals($expected, $actual);
    }

    public function testMyQrCodeReturnsPrivateQrCode() : void
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

        $winguApi = new QrCodeApi($configurationMock, $httpClient, $requestFactory, $hydrator);
        $actual   = $winguApi->myQrCode('9a8798c6-0000-4000-a000-000000000002');

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

        $expected = new PrivateQrCode(
            '9a8798c6-0000-4000-a000-000000000002',
            'Funny Cat',
            true,
            false,
            'My note',
            false,
            $expectedFunctioningHours,
            'https://wingu-sdk-test.de/qrcode/7a4b84eb-ae3f-4246-8a67-d16fbdd82595'
        );

        self::assertEquals($expected, $actual);
    }

    public function testPayloadReturnsQrCodeId() : void
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

        $winguApi = new QrCodeApi($configurationMock, $httpClient, $requestFactory, $hydrator);
        $actual   = $winguApi->payload('https://wingu-sdk-test.de/qrcode/7a4b84eb-ae3f-4246-8a67-d16fbdd82595');

        self::assertSame('9a8798c6-0000-4000-a000-000000000004', $actual);
    }
}
