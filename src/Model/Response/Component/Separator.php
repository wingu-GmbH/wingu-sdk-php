<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Component;

class Separator implements Component
{
    use ComponentTrait;

    /** @var string */
    private $type;

    public function __construct(
        string $id,
        \DateTime $updatedAt,
        string $type
    ) {
        $this->id        = $id;
        $this->updatedAt = $updatedAt;
        $this->type      = $type;
    }

    public function type() : string
    {
        return $this->type;
    }
}
