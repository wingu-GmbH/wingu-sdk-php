<?php

declare(strict_types = 1);

namespace Wingu\Engine\SDK\Model\Channel\Beacon;

use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Channel\Channel;
use Wingu\Engine\SDK\Model\Channel\ChannelTrait;

final class PublicBeacon implements Channel
{
    use ChannelTrait;
    use BeaconTrait;

    public function __construct(string $id, string $name, string $uuid, int $major, int $minor)
    {
        Assertion::uuid($id);
        Assertion::notEmpty($name);
        Assertion::uuid($uuid);
        Assertion::between($major, 1, 65535);
        Assertion::between($minor, 1, 65535);

        $this->id = $id;
        $this->name = $name;
        $this->uuid = $uuid;
        $this->major = $major;
        $this->minor = $minor;
    }
}