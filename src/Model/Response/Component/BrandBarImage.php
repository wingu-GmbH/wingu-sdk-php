<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Component;

final class BrandBarImage
{
    /** @var Image */
    private $image;

    /** @var string */
    private $alignment;

    public function __construct(Image $image, string $alignment)
    {
        $this->image     = $image;
        $this->alignment = $alignment;
    }

    public function image() : Image
    {
        return $this->image;
    }

    public function alignment() : string
    {
        return $this->alignment;
    }
}
