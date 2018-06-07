<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Component;

class Location implements Component
{
    use ComponentTrait;

    public function __construct(
        string $id,
        \DateTime $updatedAt
    ) {
        $this->id        = $id;
        $this->updatedAt = $updatedAt;
    }
}
