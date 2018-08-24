<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Tests\Model;

use PHPUnit\Framework\TestCase;
use Wingu\Engine\SDK\Model\Request\StringValue;

final class StringValueTest extends TestCase
{
    /** @return mixed[] */
    public function dataProviderTestJsonSerializeStringValues() : array
    {
        return [
            ['', '""'],
            [null, 'null'],
            ['1', '"1"'],
            ['content', '"content"'],
            ['null', '"null"'],
        ];
    }

    /** @dataProvider dataProviderTestJsonSerializeStringValues */
    public function testJsonSerializeStringValues(?string $value, string $expected) : void
    {
        $stringValue = new StringValue($value);

        self::assertEquals($expected, \json_encode($stringValue));
    }
}
