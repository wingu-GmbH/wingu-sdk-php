<?php

declare(strict_types = 1);


namespace Wingu\Engine\SDK\Model\Channel\QrCode;

use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Channel\Channel;
use Wingu\Engine\SDK\Model\Channel\ChannelTrait;

final class PublicQrCode implements Channel
{
    use ChannelTrait;
    use QrCodeTrait;

    public function __construct(string $id, string $name, string $payload)
    {
        Assertion::uuid($id);
        Assertion::notEmpty($name);

        $this->id = $id;
        $this->name = $name;

        $this->payload = $payload;
    }
}
