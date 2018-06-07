<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Channel\Beacon;

use Speicher210\BusinessHours\BusinessHoursInterface;
use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Response\Channel\ChannelTrait;
use Wingu\Engine\SDK\Model\Response\Channel\PrivateChannel;
use Wingu\Engine\SDK\Model\Response\Channel\PrivateChannelTrait;
use Wingu\Engine\SDK\Model\Response\Content\Content;

final class PrivateBeacon implements PrivateChannel
{
    use ChannelTrait;
    use PrivateChannelTrait;
    use BeaconTrait;

    public function __construct(
        string $id,
        string $name,
        bool $active,
        ?Content $content,
        bool $published,
        ?string $note,
        bool $inFunctioningHours,
        ?BusinessHoursInterface $functioningHours,
        string $uuid,
        int $major,
        int $minor,
        BeaconLocation $location
    ) {
        Assertion::uuid($id);
        Assertion::notEmpty($name);
        Assertion::uuid($uuid);
        Assertion::between($major, 1, 65535);
        Assertion::between($minor, 1, 65535);

        $this->id    = $id;
        $this->name  = $name;
        $this->uuid  = $uuid;
        $this->major = $major;
        $this->minor = $minor;

        $this->content = $content;

        $this->active    = $active;
        $this->published = $published;

        $this->note = $note;

        $this->inFunctioningHours = $inFunctioningHours;
        $this->functioningHours   = $functioningHours;

        $this->location = $location;
    }
}
