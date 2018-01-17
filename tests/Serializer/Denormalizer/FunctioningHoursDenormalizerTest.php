<?php

declare(strict_types = 1);

namespace Wingu\Engine\SDK\Tests\Serializer\Denormalizer;

use PHPUnit\Framework\TestCase;
use Speicher210\BusinessHours\BusinessHoursInterface;
use Wingu\Engine\SDK\Serializer\Denormalizer\FunctioningHoursDenormalizer;

final class FunctioningHoursDenormalizerTest extends TestCase
{
    public function testDenormalizeReturnsNullWhenDataIsNull(): void
    {
        $denormalizer = new FunctioningHoursDenormalizer();
        $actual = $denormalizer->denormalize(null, BusinessHoursInterface::class);

        self::assertNull($actual);
    }

    public function testDenormalizeReturnsBusinessHours(): void
    {
        self::markTestIncomplete('Not implemented.');
    }

    public function testDenormalizeThrowsExceptionWhenDataIsNotValid(): void
    {
        self::markTestIncomplete('Not implemented. Should use data provider.');
    }

    public function testSupportsReturnsTrueWhenTypeIsValidAndDataIsNull(): void
    {
        $denormalizer = new FunctioningHoursDenormalizer();

        self::assertTrue($denormalizer->supportsDenormalization(null, BusinessHoursInterface::class));
    }
}
