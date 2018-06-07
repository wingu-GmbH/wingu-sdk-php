<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Channel\Nfc;

trait NfcTrait
{
    /** @var string $payload */
    private $payload;

    public function payload() : string
    {
        return $this->payload;
    }
}
