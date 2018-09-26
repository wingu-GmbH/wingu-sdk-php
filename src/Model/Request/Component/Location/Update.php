<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\Location;

use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\Request;

final class Update implements Request
{
    /** @var Coordinates */
    private $coordinates;

    /** @var int|null */
    private $radius;

    public function __construct(Coordinates $coordinates, ?int $radius)
    {
        Assertion::nullOrRange($radius, 0, 2000000);
        $this->coordinates = $coordinates;
        $this->radius      = $radius;
    }

    /** @inheritdoc */
    public function jsonSerialize() : array
    {
        return [
            'coordinates' => $this->coordinates,
            'radius' => $this->radius,
        ];
    }
}
