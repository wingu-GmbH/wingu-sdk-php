<?php

declare(strict_types = 1);

namespace Wingu\Engine\SDK\Model\Channel\Geofence;

trait GeofenceTrait
{
    private $boundaries;

    public function boundaries(): Boundaries
    {
        return $this->boundaries;
    }
}
