<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\Location;

use Wingu\Engine\SDK\Model\Request\Request;

final class Coordinates implements Request
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

    /** @inheritdoc */
    public function jsonSerialize() : array
    {
        return [
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
        ];
    }
}
