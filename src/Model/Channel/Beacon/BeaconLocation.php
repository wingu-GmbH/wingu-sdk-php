<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Channel\Beacon;

class BeaconLocation
{
    /** @var Coordinates|null */
    private $coordinates;

    /** @var BeaconAddress */
    private $address;

    public function __construct(?Coordinates $coordinates = null, BeaconAddress $address)
    {
        $this->coordinates = $coordinates;
        $this->address     = $address;
    }

    public function coordinates() : ?Coordinates
    {
        return $this->coordinates;
    }

    public function address() : BeaconAddress
    {
        return $this->address;
    }
}
