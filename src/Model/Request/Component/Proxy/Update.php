<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\Proxy;

use Wingu\Engine\SDK\Model\Request\Request;

final class Update implements Request
{
    /** @var string|null */
    private $payload;

    public function __construct(?string $payload)
    {
        $this->payload = $payload;
    }

    /** @inheritdoc */
    public function jsonSerialize()
    {
        return [
            'payload' => $this->payload,
        ];
    }
}
