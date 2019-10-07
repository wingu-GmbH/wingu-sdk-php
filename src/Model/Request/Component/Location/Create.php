<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\Location;

use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\Request;

final class Create implements Request
{
    private const MAX_VALUE = 2000000;

    /** @var Coordinates */
    private $coordinates;

    /** @var int */
    private $radius;

    public function __construct(Coordinates $coordinates, int $radius)
    {
        Assertion::range($radius, 0, self::MAX_VALUE);
        $this->coordinates = $coordinates;
        $this->radius      = $radius;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize() : array
    {
        return [
            'coordinates' => $this->coordinates,
            'radius' => $this->radius,
        ];
    }
}
