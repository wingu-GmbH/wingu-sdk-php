<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Tests\Api;

use GuzzleHttp\Psr7\Response;
use Wingu\Engine\SDK\Api\Configuration;
use Wingu\Engine\SDK\Api\Country;
use Wingu\Engine\SDK\Api\Exception\Generic;
use Wingu\Engine\SDK\Model\Response\Country as CountryModel;

final class CountryTest extends ApiTest
{
    public function testCountriesThrowsExceptionWhenResponseIsNot200() : void
    {
        $countryApi = $this->createCountryService(
            new Response(500, ['Content-Type' => 'application/json'], '{"code": 500, "errors": []}')
        );

        $this->expectException(Generic::class);
        $this->expectExceptionMessage('Remote server error.');

        $countryApi->countries();
    }

    public function testPingReturnsResult() : void
    {
        $countryApi = $this->createCountryService(
            new Response(
                200,
                ['Content-Type' => 'application/json'],
                '[{"iso_3166_1_alpha_2":"DE","name":"Germany"},{"iso_3166_1_alpha_2":"PL","name":"Poland"},{"iso_3166_1_alpha_2":"RO","name":"Romania"}]'
            )
        );
        $actual     = $countryApi->countries();

        $expected = [
            new CountryModel('DE', 'Germany'),
            new CountryModel('PL', 'Poland'),
            new CountryModel('RO', 'Romania'),
        ];
        self::assertEquals($expected, $actual);
    }

    private function createCountryService(Response ...$httpClientResponses) : Country
    {
        $configurationMock = new Configuration();

        $httpClient = self::createClient();
        foreach ($httpClientResponses as $httpClientResponse) {
            $httpClient->addResponse($httpClientResponse);
        }

        return new Country($configurationMock, $httpClient);
    }
}
