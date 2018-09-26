<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Component;

use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Response\Coordinates;

class Location implements Component
{
    use ComponentTrait;

    /** @var Coordinates */
    private $coordinates;

    /** @var int */
    private $radius;

    public function __construct(
        string $id,
        \DateTime $updatedAt,
        Coordinates $coordinates,
        int $radius
    ) {
        Assertion::range($radius, 0, 2000000);

        $this->id          = $id;
        $this->updatedAt   = $updatedAt;
        $this->coordinates = $coordinates;
        $this->radius      = $radius;
    }

    public function coordinates() : Coordinates
    {
        return $this->coordinates;
    }

    public function radius() : int
    {
        return $this->radius;
    }
}
