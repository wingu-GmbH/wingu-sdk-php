<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\ImageGallery\Image;

use Psr\Http\Message\StreamInterface;
use Wingu\Engine\SDK\Model\Request\MultipartRequest;

final class Create implements MultipartRequest
{
    /** @var StreamInterface */
    private $image;

    /** @var string|null */
    private $caption;

    public function __construct(StreamInterface $image, ?string $caption)
    {
        $this->image   = $image;
        $this->caption = $caption;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize() : array
    {
        return [
            'caption' => $this->caption,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function files() : array
    {
        return [
            'image' => $this->image,
        ];
    }
}
