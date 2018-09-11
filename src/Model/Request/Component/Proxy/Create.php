<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\Proxy;

use Wingu\Engine\SDK\Model\Request\Request;

final class Create implements Request
{
    /** @var string */
    private $payload;

    public function __construct(string $payload)
    {
        $this->payload = $payload;
    }

    /** @inheritdoc */
    public function jsonSerialize() : array
    {
        return [
            'payload' => $this->payload,
        ];
    }
}
