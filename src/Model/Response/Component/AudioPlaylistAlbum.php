<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Component;

final class AudioPlaylistAlbum
{
    /** @var string|null */
    private $name;

    /** @var AudioPlaylistCover|null */
    private $cover;

    public function __construct(?string $name, ?AudioPlaylistCover $cover)
    {
        $this->name  = $name;
        $this->cover = $cover;
    }

    public function name() : ?string
    {
        return $this->name;
    }

    public function cover() : ?AudioPlaylistCover
    {
        return $this->cover;
    }
}
