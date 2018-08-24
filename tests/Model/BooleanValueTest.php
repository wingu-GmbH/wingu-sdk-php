<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Tests\Model;

use PHPUnit\Framework\TestCase;
use Wingu\Engine\SDK\Model\Request\BooleanValue;

final class BooleanValueTest extends TestCase
{
    /** @return mixed[] */
    public function dataProviderTestJsonSerializeBooleanValues() : array
    {
        return [
            [null, 'null'],
            [true, '"1"'],
            [false, '"0"'],
        ];
    }

    /** @dataProvider dataProviderTestJsonSerializeBooleanValues */
    public function testJsonSerializeBooleanValues(?bool $value, string $expected) : void
    {
        $booleanValue = new BooleanValue($value);

        self::assertEquals($expected, \json_encode($booleanValue));
    }
}
