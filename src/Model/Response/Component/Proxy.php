<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Component;

class Proxy implements Component
{
    use ComponentTrait;

    /** @var string */
    private $payload;

    public function __construct(
        string $id,
        \DateTime $updatedAt,
        string $payload
    ) {
        $this->id        = $id;
        $this->updatedAt = $updatedAt;
        $this->payload   = $payload;
    }

    public function payload() : string
    {
        return $this->payload;
    }
}
