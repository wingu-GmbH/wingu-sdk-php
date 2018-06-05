<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Channel\QrCode;

use Speicher210\BusinessHours\BusinessHoursInterface;
use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Channel\ChannelTrait;
use Wingu\Engine\SDK\Model\Channel\PrivateChannel;
use Wingu\Engine\SDK\Model\Channel\PrivateChannelTrait;
use Wingu\Engine\SDK\Model\Content\Content;

final class PrivateQrCode implements PrivateChannel
{
    use ChannelTrait;
    use PrivateChannelTrait;
    use QrCodeTrait;

    public function __construct(
        string $id,
        string $name,
        bool $active,
        ?Content $content,
        bool $published,
        ?string $note,
        bool $inFunctioningHours,
        ?BusinessHoursInterface $functioningHours,
        string $payload
    ) {
        Assertion::uuid($id);
        Assertion::notEmpty($name);

        $this->id   = $id;
        $this->name = $name;

        $this->content = $content;

        $this->active    = $active;
        $this->published = $published;

        $this->note = $note;

        $this->inFunctioningHours = $inFunctioningHours;
        $this->functioningHours   = $functioningHours;

        $this->payload = $payload;
    }
}
