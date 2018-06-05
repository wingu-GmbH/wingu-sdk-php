<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Component;

class Video implements Component
{
    use ComponentTrait;

    /** @var string */
    private $type;

    /** @var string */
    private $payload;

    /** @var string|null */
    private $description;

    public function __construct(
        string $id,
        \DateTime $updatedAt,
        string $type,
        string $payload,
        ?string $description
    ) {
        $this->id          = $id;
        $this->updatedAt   = $updatedAt;
        $this->type        = $type;
        $this->payload     = $payload;
        $this->description = $description;
    }

    public function type() : string
    {
        return $this->type;
    }

    public function payload() : string
    {
        return $this->payload;
    }

    public function description() : ?string
    {
        return $this->description;
    }
}
