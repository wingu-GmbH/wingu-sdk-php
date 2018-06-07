<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Channel\QrCode;

trait QrCodeTrait
{
    /** @var string $payload */
    private $payload;

    public function payload() : string
    {
        return $this->payload;
    }
}
