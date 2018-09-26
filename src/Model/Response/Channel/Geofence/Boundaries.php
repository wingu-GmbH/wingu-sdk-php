<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Channel\Geofence;

final class Boundaries
{
    /** @var string */
    private $type;

    /** @var mixed[] */
    private $coordinates;

    /**
     * @param mixed[] $coordinates
     */
    public function __construct(string $type, array $coordinates)
    {
        $this->type        = $type;
        $this->coordinates = $coordinates;
    }

    public function type() : string
    {
        return $this->type;
    }

    /**
     * @return mixed[]
     */
    public function coordinates() : array
    {
        return $this->coordinates;
    }
}
