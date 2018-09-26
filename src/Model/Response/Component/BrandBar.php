<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Component;

final class BrandBar implements Component
{
    use ComponentTrait;

    /** @var BrandBarBackground|null */
    private $background;

    /** @var BrandBarText|null */
    private $text;

    /** @var BrandBarImage|null */
    private $image;

    public function __construct(
        string $id,
        \DateTime $updatedAt,
        BrandBarBackground $background,
        ?BrandBarText $text,
        ?BrandBarImage $image
    ) {
        if ($text === null && $image === null) {
            throw new \InvalidArgumentException('BrandBar requires either Text or Image, or both');
        }

        $this->id         = $id;
        $this->updatedAt  = $updatedAt;
        $this->background = $background;
        $this->text       = $text;
        $this->image      = $image;
    }

    public function background() : ?BrandBarBackground
    {
        return $this->background;
    }

    public function text() : ?BrandBarText
    {
        return $this->text;
    }

    public function image() : ?BrandBarImage
    {
        return $this->image;
    }
}
