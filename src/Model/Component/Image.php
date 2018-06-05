<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Component;

use Wingu\Engine\SDK\Model\Component\ImageMetadata as Metadata;

class Image
{
    /** @var Metadata */
    private $metadata;

    /** @var string */
    private $cloudinaryId;

    /** @var string */
    private $type;

    public function __construct(Metadata $metadata, string $cloudinaryId, string $type)
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
