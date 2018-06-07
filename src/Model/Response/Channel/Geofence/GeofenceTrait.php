<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Channel\Geofence;

trait GeofenceTrait
{
    /** @var Boundaries $boundaries */
    private $boundaries;

    public function boundaries() : Boundaries
    {
        return $this->boundaries;
    }
}
