<?php

declare(strict_types = 1);

namespace Wingu\Engine\SDK\Model\Channel\Nfc;

trait NfcTrait
{
    private $payload;

    public function payload(): string
    {
        return $this->payload;
    }
}
