<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Component;

final class CMS implements Component
{
    use ComponentTrait;

    /** @var string */
    private $content;

    /** @var string */
    private $type;

    public function __construct(
        string $id,
        \DateTime $updatedAt,
        string $content,
        string $type
    ) {
        $this->id        = $id;
        $this->updatedAt = $updatedAt;
        $this->content   = $content;
        $this->type      = $type;
    }

    public function content() : string
    {
        return $this->content;
    }

    public function type() : string
    {
        return $this->type;
    }
}
