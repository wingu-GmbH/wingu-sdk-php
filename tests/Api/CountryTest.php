<?php

declare(strict_types = 1);

namespace Wingu\Engine\SDK\Tests\Api;

use GuzzleHttp\Psr7\Response;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use Http\Mock\Client as MockClient;
use Wingu\Engine\SDK\Api\Configuration;
use Wingu\Engine\SDK\Api\Country;
use Wingu\Engine\SDK\Api\Exception;
use Wingu\Engine\SDK\Hydrator\Hydrator;
use Wingu\Engine\SDK\Hydrator\SymfonySerializerHydrator;
use Wingu\Engine\SDK\Model\Country as CountryModel;

final class CountryTest extends ApiTest
{
    public function testCountriesThrowsExceptionWhenResponseIsNot200(): void
    {
        $configurationMock = new Configuration();
        $requestFactory = new GuzzleMessageFactory();
        $hydrator = $this->createMock(Hydrator::class);

        $httpClient = new MockClient();
        $httpClient->addResponse(
            new Response(500, ['Content-Type' => 'application/json'], '{"code": 500, "errors": []}')
        );

        $winguApi = new Country($configurationMock, $httpClient, $requestFactory, $hydrator);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Remote server error.');

        $winguApi->countries();
    }

    public function testPingReturnsResult(): void
    {
        $configurationMock = new Configuration();
        $requestFactory = new GuzzleMessageFactory();
        $hydrator = new SymfonySerializerHydrator();

        $httpClient = new MockClient();
        $httpClient->addResponse(
            new Response(
                200,
                ['Content-Type' => 'application/json'],
                '[{"iso_3166_1_alpha_2":"DE","name":"Germany"},{"iso_3166_1_alpha_2":"PL","name":"Poland"},{"iso_3166_1_alpha_2":"RO","name":"Romania"}]'
            )
        );

        $winguApi = new Country($configurationMock, $httpClient, $requestFactory, $hydrator);
        $actual = $winguApi->countries();

        $expected = [
            new CountryModel('DE', 'Germany'),
            new CountryModel('PL', 'Poland'),
            new CountryModel('RO', 'Romania')
        ];
        self::assertEquals($expected, $actual);
    }
}
