<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Tests\Api;

use PHPUnit\Framework\TestCase;
use Speicher210\BusinessHours\BusinessHours;
use Speicher210\BusinessHours\Day\AllDay;
use Speicher210\BusinessHours\Day\Day;
use Speicher210\BusinessHours\Day\Time\TimeInterval;

abstract class ChannelApiTestCase extends TestCase
{
    protected function getExpectedFunctioningHours() : BusinessHours
    {
        return new BusinessHours(
            [
                new AllDay(Day::WEEK_DAY_MONDAY),
                new Day(
                    Day::WEEK_DAY_WEDNESDAY,
                    [
                        TimeInterval::fromString('08:00', '12:00'),
                        TimeInterval::fromString('13:00', '18:00'),
                    ]
                ),
                new AllDay(Day::WEEK_DAY_FRIDAY),
            ],
            new \DateTimeZone('Europe/Berlin')
        );
    }
}
