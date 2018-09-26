<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response;

class Coordinates
{
    /** @var float */
    private $longitude;

    /** @var float */
    private $latitude;

    public function __construct(float $longitude, float $latitude)
    {
        $this->longitude = $longitude;
        $this->latitude  = $latitude;
    }

    public function longitude() : float
    {
        return $this->longitude;
    }

    public function latitude() : float
    {
        return $this->latitude;
    }
}
