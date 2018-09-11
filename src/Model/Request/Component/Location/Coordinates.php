<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\Location;

use Wingu\Engine\SDK\Model\Request\Request;

final class Coordinates implements Request
{
    /** @var string */
    private $longitude;

    /** @var string */
    private $latitude;

    public function __construct(string $longitude, string $latitude)
    {
        $this->longitude = $longitude;
        $this->latitude  = $latitude;
    }

    /** @inheritdoc */
    public function jsonSerialize()
    {
        return [
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
        ];
    }
}
