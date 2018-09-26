<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Channel\Beacon;

use Wingu\Engine\SDK\Model\Response\Coordinates;

class BeaconLocation
{
    /** @var Coordinates|null */
    private $coordinates;

    /** @var BeaconAddress */
    private $address;

    public function __construct(BeaconAddress $address, ?Coordinates $coordinates = null)
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
