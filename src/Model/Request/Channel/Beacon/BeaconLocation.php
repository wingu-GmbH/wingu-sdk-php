<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Channel\Beacon;

use Wingu\Engine\SDK\Model\Request\Request;

final class BeaconLocation implements Request
{
    /** @var null|Coordinates */
    private $coordinates;

    /** @var null|BeaconAddress */
    private $address;

    public function __construct(?Coordinates $coordinates, ?BeaconAddress $address)
    {
        $this->coordinates = $coordinates;
        $this->address     = $address;
    }

    /** @inheritdoc */
    public function jsonSerialize() : array
    {
        return [
            'coordinates' => $this->coordinates,
            'address'  => $this->address,
        ];
    }
}
