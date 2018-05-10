<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Tests\Serializer\Denormalizer;

use PHPUnit\Framework\TestCase;
use Speicher210\BusinessHours\BusinessHoursInterface;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Wingu\Engine\SDK\Serializer\Denormalizer\FunctioningHoursDenormalizer;

final class FunctioningHoursDenormalizerTest extends TestCase
{
    public function testDenormalizeReturnsNullWhenDataIsNull() : void
    {
        $denormalizer = new FunctioningHoursDenormalizer();
        $actual       = $denormalizer->denormalize(null, BusinessHoursInterface::class);

        self::assertNull($actual);
    }

    public function testDenormalizeReturnsBusinessHours() : void
    {
        $data = [
            'days' => [
                [
                    'dayOfWeek' => 1,
                    'intervals' => [
                        [
                            'start' => [
                                'hours' => 1,
                                'minutes' => 0,
                                'seconds' => 0,
                            ],
                            'end' => [
                                'hours' => 2,
                                'minutes' => 0,
                                'seconds' => 0,
                            ],
                        ],
                    ],
                ],
            ],
            'timezone' => 'Europe/Berlin',
        ];

        $denormalizer = new FunctioningHoursDenormalizer();
        $actual       = $denormalizer->denormalize($data, BusinessHoursInterface::class);

        self::assertInstanceOf(BusinessHoursInterface::class, $actual);
    }

    public static function dataProviderInvalidDataForDenormalizer() : array
    {
        return [
            [
                ['timezone' => []],
            ],
            [
                ['days' => []],
            ],
            [
                ['days' => [], 'timezone' => ''],
            ],
            [
                [
                    'days' => [
                        ['dayOfWeek' => 1],
                    ],
                    'timezone' => '',
                ],
            ],
            [
                [
                    'days' => [
                        ['intervals' => []],
                    ],
                    'timezone' => '',
                ],
            ],
            [
                [
                    'days' => [
                        [
                            'dayOfWeek' => 1,
                            'intervals' => [],
                        ],
                    ],
                    'timezone' => '',
                ],
            ],
            [
                [
                    'days' => [
                        [
                            'dayOfWeek' => 1,
                            'intervals' => [
                                [
                                    'start' => [
                                        'hours' => 1,
                                        'minutes' => 0,
                                        'seconds' => 0,
                                    ],
                                    'end' => [
                                        'hours' => 0,
                                        'minutes' => 0,
                                        'seconds' => 0,
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'timezone' => 'Europe/Berlin',
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderInvalidDataForDenormalizer
     * @param array $data
     */
    public function testDenormalizeThrowsExceptionWhenDataIsNotValid(array $data) : void
    {
        $denormalizer = new FunctioningHoursDenormalizer();

        $this->expectException(NotNormalizableValueException::class);
        $this->expectExceptionMessage('Invalid functioning hours data.');
        $denormalizer->denormalize($data, BusinessHoursInterface::class);
    }

    public function testSupportsReturnsTrueWhenTypeIsValidAndDataIsNull() : void
    {
        $denormalizer = new FunctioningHoursDenormalizer();

        self::assertTrue($denormalizer->supportsDenormalization(null, BusinessHoursInterface::class));
    }
}
