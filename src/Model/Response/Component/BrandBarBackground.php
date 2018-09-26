<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Component;

final class BrandBarBackground
{
    /** @var string */
    private $color;

    public function __construct(string $color)
    {
        $this->color = $color;
    }

    public function color() : string
    {
        return $this->color;
    }
}
