<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Tests\Serializer\Denormalizer;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Wingu\Engine\SDK\Model\Country;
use Wingu\Engine\SDK\Serializer\Denormalizer\CountryDenormalizer;

final class CountryDenormalizerTest extends TestCase
{
    public function testSupportsDenormalizationReturnsTrueForCountryModelType() : void
    {
        $countryNormalizer = new CountryDenormalizer();

        self::assertTrue($countryNormalizer->supportsDenormalization([], Country::class));
    }

    public function testSupportsDenormalizationReturnsFalseForNotCountryModelType() : void
    {
        $countryNormalizer = new CountryDenormalizer();

        self::assertFalse($countryNormalizer->supportsDenormalization([], \stdClass::class));
    }

    public function testDenormalizeThrowsExceptionWhenDataIsNotArray() : void
    {
        $countryNormalizer = new CountryDenormalizer();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Data expected to be an array, string given.');

        $countryNormalizer->denormalize('string', Country::class);
    }

    public function testDenormalizeThrowsExceptionWhenDataIsMissingNameKey() : void
    {
        $countryNormalizer = new CountryDenormalizer();

        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage('Expected a valid country data payload.');

        $countryNormalizer->denormalize(['iso_3166_1_alpha_2' => 'de'], Country::class);
    }

    public function testDenormalizeThrowsExceptionWhenDataIsMissingIsoCodeKey() : void
    {
        $countryNormalizer = new CountryDenormalizer();

        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage('Expected a valid country data payload.');

        $countryNormalizer->denormalize(['name' => 'Germany'], Country::class);
    }

    public function testDenormalizeThrowsExceptionWhenDataHasInvalidIsoCode() : void
    {
        $countryNormalizer = new CountryDenormalizer();

        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage('Value "a" has to be 2 exactly characters long, but length is 1.');

        $countryNormalizer->denormalize(['iso_3166_1_alpha_2' => 'a', 'name' => 'Germany'], Country::class);
    }

    public function testDenormalizeThrowsExceptionWhenDataHasInvalidName() : void
    {
        $countryNormalizer = new CountryDenormalizer();

        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage('Value "" is empty, but non empty value was expected.');

        $countryNormalizer->denormalize(['iso_3166_1_alpha_2' => 'de', 'name' => ''], Country::class);
    }

    public function testDenormalizeCountryModel() : void
    {
        $countryNormalizer = new CountryDenormalizer();

        $actual = $countryNormalizer->denormalize(['iso_3166_1_alpha_2' => 'de', 'name' => 'Germany'], Country::class);

        $expected = new Country('DE', 'Germany');
        self::assertEquals($expected, $actual);
    }
}
