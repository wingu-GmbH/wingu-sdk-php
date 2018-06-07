<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Channel\Nfc;

use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Response\Channel\Channel;
use Wingu\Engine\SDK\Model\Response\Channel\ChannelTrait;

final class PublicNfc implements Channel
{
    use ChannelTrait;
    use NfcTrait;

    public function __construct(string $id, string $name, string $payload)
    {
        Assertion::uuid($id);
        Assertion::notEmpty($name);

        $this->id   = $id;
        $this->name = $name;

        $this->payload = $payload;
    }
}
