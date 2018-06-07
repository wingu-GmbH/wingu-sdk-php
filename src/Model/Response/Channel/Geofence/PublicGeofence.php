<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Channel\Geofence;

use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Response\Channel\Channel;
use Wingu\Engine\SDK\Model\Response\Channel\ChannelTrait;

final class PublicGeofence implements Channel
{
    use ChannelTrait;
    use GeofenceTrait;

    public function __construct(string $id, string $name, Boundaries $boundaries)
    {
        Assertion::uuid($id);
        Assertion::notEmpty($name);

        $this->id   = $id;
        $this->name = $name;

        $this->boundaries = $boundaries;
    }
}
