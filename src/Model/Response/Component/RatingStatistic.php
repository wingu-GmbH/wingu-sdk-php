<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Component;

class RatingStatistic
{
    /** @var RatingRates */
    private $ratings;

    /** @var \DateTimeImmutable */
    private $startDate;

    public function __construct(RatingRates $ratings, \DateTimeImmutable $startDate)
    {
        $this->ratings   = $ratings;
        $this->startDate = $startDate;
    }

    public function ratings() : RatingRates
    {
        return $this->ratings;
    }

    public function startDate() : \DateTimeImmutable
    {
        return $this->startDate;
    }
}
