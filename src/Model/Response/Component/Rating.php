<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Component;

class Rating implements Component
{
    use ComponentTrait;

    /** @var string */
    private $title;

    public function __construct(
        string $id,
        \DateTime $updatedAt,
        string $title
    ) {
        $this->id        = $id;
        $this->updatedAt = $updatedAt;
        $this->title     = $title;
    }

    public function title() : string
    {
        return $this->title;
    }
}
