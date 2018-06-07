<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Component;

class ImageGalleryImage
{
    /** @var string */
    private $id;

    /** @var int */
    private $position;

    /** @var Image */
    private $image;

    /** @var string|null */
    private $caption;

    public function __construct(string $id, int $position, Image $image, ?string $caption)
    {
        $this->id       = $id;
        $this->position = $position;
        $this->image    = $image;
        $this->caption  = $caption;
    }

    public function id() : string
    {
        return $this->id;
    }

    public function position() : int
    {
        return $this->position;
    }

    public function image() : Image
    {
        return $this->image;
    }

    public function caption() : ?string
    {
        return $this->caption;
    }
}
