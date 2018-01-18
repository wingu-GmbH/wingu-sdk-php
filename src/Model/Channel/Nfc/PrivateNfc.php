<?php

declare(strict_types = 1);

namespace Wingu\Engine\SDK\Model\Channel\Nfc;

use Speicher210\BusinessHours\BusinessHoursInterface;
use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Channel\ChannelTrait;
use Wingu\Engine\SDK\Model\Channel\PrivateChannel;
use Wingu\Engine\SDK\Model\Channel\PrivateChannelTrait;

final class PrivateNfc implements PrivateChannel
{
    use ChannelTrait;
    use PrivateChannelTrait;
    use NfcTrait;

    public function __construct(
        string $id,
        string $name,
        bool $active,
        bool $published,
        ?string $note,
        bool $inFunctioningHours,
        ?BusinessHoursInterface $functioningHours,
        string $payload
    ) {
        Assertion::uuid($id);
        Assertion::notEmpty($name);

        $this->id = $id;
        $this->name = $name;

        $this->active = $active;
        $this->published = $published;

        $this->note = $note;

        $this->inFunctioningHours = $inFunctioningHours;
        $this->functioningHours = $functioningHours;

        $this->payload = $payload;
    }
}
