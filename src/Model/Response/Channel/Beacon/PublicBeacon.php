<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Channel\Beacon;

use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Response\Channel\Channel;
use Wingu\Engine\SDK\Model\Response\Channel\ChannelTrait;
use Wingu\Engine\SDK\Model\Response\Content\PublicContent;

final class PublicBeacon implements Channel
{
    use ChannelTrait;
    use BeaconTrait;

    /** @var PublicContent */
    private $content;

    public function __construct(
        string $id,
        string $name,
        string $uuid,
        int $major,
        int $minor,
        PublicContent $content,
        BeaconLocation $location
    ) {
        Assertion::uuid($id);
        Assertion::notEmpty($name);
        Assertion::uuid($uuid);
        Assertion::between($major, 1, 65535);
        Assertion::between($minor, 1, 65535);

        $this->id       = $id;
        $this->name     = $name;
        $this->uuid     = $uuid;
        $this->major    = $major;
        $this->minor    = $minor;
        $this->location = $location;

        $this->content = $content;
    }

    public function content() : PublicContent
    {
        return $this->content;
    }
}
