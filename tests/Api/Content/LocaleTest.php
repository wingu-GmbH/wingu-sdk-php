<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Tests\Api\Content;

use GuzzleHttp\Psr7\Response;
use Wingu\Engine\SDK\Api\Configuration;
use Wingu\Engine\SDK\Api\Content\Locale;
use Wingu\Engine\SDK\Model\Response\Content\Locale as ResponseLocale;
use Wingu\Engine\SDK\Tests\Api\ApiTest;

final class LocaleTest extends ApiTest
{
    public function testLocalesReturnsLocales() : void
    {
        $configurationMock = new Configuration();

        $httpClient = self::createClient();
        $httpClient->addResponse(
            new Response(
                200,
                ['Content-Type' => 'application/json'],
                $this->getDataFromFixturesFile('content_locales.json')
            )
        );

        $winguApi = new Locale($configurationMock, $httpClient);
        $actual   = $winguApi->locales();

        $expected = [
            $this->getExpectedGermanLanguage(),
            $this->getExpectedEnglishLanguage(),
            $this->getExpectedSpanishLanguage(),
            $this->getExpectedPolishLanguage(),
        ];

        self::assertCount(4, $actual);
        self::assertEquals($expected, $actual);
    }

    private function getExpectedGermanLanguage() : ResponseLocale
    {
        return new ResponseLocale(
            'german',
            'de'
        );
    }

    private function getExpectedEnglishLanguage() : ResponseLocale
    {
        return new ResponseLocale(
            'english',
            'en'
        );
    }

    private function getExpectedSpanishLanguage() : ResponseLocale
    {
        return new ResponseLocale(
            'spanish',
            'es'
        );
    }

    private function getExpectedPolishLanguage() : ResponseLocale
    {
        return new ResponseLocale(
            'polish',
            'pl'
        );
    }
}
