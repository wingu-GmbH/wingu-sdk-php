<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Component;

class RatingRates
{
    /** @var int */
    private $one;

    /** @var int */
    private $two;

    /** @var int */
    private $three;

    /** @var int */
    private $four;

    /** @var int */
    private $five;

    /** @var float */
    private $average;

    public function __construct(int $one, int $two, int $three, int $four, int $five, float $average)
    {
        $this->one     = $one;
        $this->two     = $two;
        $this->three   = $three;
        $this->four    = $four;
        $this->five    = $five;
        $this->average = $average;
    }

    public function one() : int
    {
        return $this->one;
    }

    public function two() : int
    {
        return $this->two;
    }

    public function three() : int
    {
        return $this->three;
    }

    public function four() : int
    {
        return $this->four;
    }

    public function five() : int
    {
        return $this->five;
    }

    public function average() : float
    {
        return $this->average;
    }
}
