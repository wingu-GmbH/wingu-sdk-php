<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Component;

use Wingu\Engine\SDK\Model\Response\Component\ImageGalleryImage as Image;

class ImageGallery implements Component
{
    use ComponentTrait;

    /** @var Image[] */
    private $images;

    /**
     * @param Image[] $images
     */
    public function __construct(string $id, \DateTime $updatedAt, array $images)
    {
        $this->id        = $id;
        $this->updatedAt = $updatedAt;
        $this->images    = $images;
    }

    /**
     * @return Image[]
     */
    public function images() : array
    {
        return $this->images;
    }
}
