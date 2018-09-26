<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Component;

class Separator implements Component
{
    use ComponentTrait;

    /** @var string */
    private $type;

    /** @var string */
    private $colorHex;

    public function __construct(
        string $id,
        \DateTime $updatedAt,
        string $type,
        string $colorHex
    ) {
        $this->id        = $id;
        $this->updatedAt = $updatedAt;
        $this->type      = $type;
        $this->colorHex  = $colorHex;
    }

    public function type() : string
    {
        return $this->type;
    }

    public function colorHex() : string
    {
        return $this->colorHex;
    }
}
