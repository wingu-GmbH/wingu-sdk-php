<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Component;

final class AudioPlaylistCover
{
    /** @var ImageMetadata */
    private $metadata;

    /** @var string */
    private $cloudinaryId;

    /** @var string */
    private $type;

    public function __construct(ImageMetadata $metadata, string $cloudinaryId, string $type)
    {
        $this->metadata     = $metadata;
        $this->cloudinaryId = $cloudinaryId;
        $this->type         = $type;
    }

    public function metadata() : ImageMetadata
    {
        return $this->metadata;
    }

    public function cloudinaryId() : string
    {
        return $this->cloudinaryId;
    }

    public function type() : string
    {
        return $this->type;
    }
}
