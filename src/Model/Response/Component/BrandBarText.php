<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Component;

final class BrandBarText
{
    /** @var string */
    private $text;

    /** @var string */
    private $alignment;

    /** @var string */
    private $color;

    public function __construct(string $text, string $alignment, string $color)
    {
        $this->text      = $text;
        $this->alignment = $alignment;
        $this->color     = $color;
    }

    public function text() : string
    {
        return $this->text;
    }

    public function alignment() : string
    {
        return $this->alignment;
    }

    public function color() : string
    {
        return $this->color;
    }
}
