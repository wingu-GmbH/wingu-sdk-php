<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Component;

use Wingu\Engine\SDK\Model\Response\Component\AudioPlaylistAlbum as Album;

final class AudioPlaylistMedia
{
    /** @var string */
    private $id;

    /** @var int */
    private $position;

    /** @var string */
    private $fileUrl;

    /** @var string */
    private $name;

    /** @var int */
    private $length;

    /** @var Album|null */
    private $album;

    public function __construct(
        string $id,
        int $position,
        string $fileUrl,
        string $name,
        int $length,
        ?Album $album
    ) {
        $this->id       = $id;
        $this->position = $position;
        $this->fileUrl  = $fileUrl;
        $this->name     = $name;
        $this->length   = $length;
        $this->album    = $album;
    }

    public function id() : string
    {
        return $this->id;
    }

    public function position() : int
    {
        return $this->position;
    }

    public function fileUrl() : string
    {
        return $this->fileUrl;
    }

    public function name() : string
    {
        return $this->name;
    }

    public function length() : int
    {
        return $this->length;
    }

    public function album() : ?Album
    {
        return $this->album;
    }
}
