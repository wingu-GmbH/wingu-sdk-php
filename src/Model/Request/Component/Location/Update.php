<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\Location;

use Wingu\Engine\SDK\Model\Request\Request;

final class Update implements Request
{
    /** @var Coordinates */
    private $coordinates;

    /** @var string|null */
    private $radius;

    public function __construct(Coordinates $coordinates, ?string $radius)
    {
        $this->coordinates = $coordinates;
        $this->radius      = $radius;
    }

    /** @inheritdoc */
    public function jsonSerialize()
    {
        return [
            'coordinates' => $this->coordinates,
            'radius' => $this->radius,
        ];
    }
}
