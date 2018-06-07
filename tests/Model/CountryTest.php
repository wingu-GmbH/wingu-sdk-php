<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Tests\Model;

use PHPUnit\Framework\TestCase;
use Wingu\Engine\SDK\Exception\AssertInvalidArgument;
use Wingu\Engine\SDK\Model\Response\Country;

final class CountryTest extends TestCase
{
    public function testInstantiatingWithEmptyNameThrowsException() : void
    {
        $this->expectException(AssertInvalidArgument::class);
        $this->expectExceptionMessage('Value "" is empty, but non empty value was expected.');

        new Country('ro', '');
    }

    public function testInstantiatingWithCountryCodeLengthLowerThan2ThrowsException() : void
    {
        $this->expectException(AssertInvalidArgument::class);
        $this->expectExceptionMessage('Value "a" has to be 2 exactly characters long, but length is 1.');

        new Country('a', 'country');
    }

    public function testInstantiatingWithCountryCodeLengthBiggerThan2ThrowsException() : void
    {
        $this->expectException(AssertInvalidArgument::class);
        $this->expectExceptionMessage('Value "abc" has to be 2 exactly characters long, but length is 3.');

        new Country('abc', 'country');
    }

    public function testCountryIso31661Alpha2IsCapitalized() : void
    {
        $country = new Country('aa', 'country');
        self::assertSame('AA', $country->iso31661Alpha2());
    }
}
