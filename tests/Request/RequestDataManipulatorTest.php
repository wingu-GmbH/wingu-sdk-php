<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Tests\Request;

use PHPUnit\Framework\TestCase;
use Wingu\Engine\SDK\Model\Request\Request;
use Wingu\Engine\SDK\Request\RequestDataManipulator;

final class RequestDataManipulatorTest extends TestCase
{
    /**
     * @return mixed[]
     */
    public static function dataProviderTestFlatten() : array
    {
        return [
            [[], []],
            [
                ['a' => 'b'],
                ['a' => 'b'],
            ],
            [
                [
                    'a' => 'b',
                    'b' => [
                        'c' => 'd',
                        'e' => 'f',
                    ],
                ],
                [
                    'a' => 'b',
                    'b[c]' => 'd',
                    'b[e]' => 'f',
                ],
            ],
        ];
    }

    /**
     * @param mixed[] $data
     * @param mixed[] $expected
     *
     * @dataProvider dataProviderTestFlatten
     */
    public function testFlatten(array $data, array $expected) : void
    {
        $requestMock = $this->createMock(Request::class);
        $requestMock->method('jsonSerialize')->willReturn($data);

        self::assertSame($expected, RequestDataManipulator::flatten($requestMock));
    }
}
