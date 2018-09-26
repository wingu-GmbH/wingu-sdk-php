<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Component;

final class ImageMetadata
{
    /** @var string */
    private $format;

    /** @var int */
    private $width;

    /** @var int */
    private $height;

    public function __construct(string $format, int $width, int $height)
    {
        $this->format = $format;
        $this->width  = $width;
        $this->height = $height;
    }

    public function format() : string
    {
        return $this->format;
    }

    public function width() : int
    {
        return $this->width;
    }

    public function height() : int
    {
        return $this->height;
    }
}
