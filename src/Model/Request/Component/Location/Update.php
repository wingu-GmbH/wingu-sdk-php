<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\Location;

use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\Request;

final class Update implements Request
{
    private const MAX_VALUE = 2000000;

    /** @var Coordinates|null */
    private $coordinates;

    /** @var int|null */
    private $radius;

    public function __construct(?Coordinates $coordinates = null, ?int $radius = null)
    {
        Assertion::nullOrRange($radius, 0, self::MAX_VALUE);
        $this->coordinates = $coordinates;
        $this->radius      = $radius;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize() : array
    {
        return \array_filter([
            'coordinates' => $this->coordinates,
            'radius' => $this->radius,
        ]);
    }
}
