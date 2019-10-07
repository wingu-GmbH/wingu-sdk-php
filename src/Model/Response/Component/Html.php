<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Component;

final class Html implements Component
{
    use ComponentTrait;

    /** @var string */
    private $content;

    public function __construct(string $id, \DateTime $updatedAt, string $content)
    {
        $this->id        = $id;
        $this->updatedAt = $updatedAt;
        $this->content   = $content;
    }

    public function content() : string
    {
        return $this->content;
    }
}
