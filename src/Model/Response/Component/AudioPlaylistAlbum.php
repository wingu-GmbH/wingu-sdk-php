<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Component;

final class AudioPlaylistAlbum
{
    /** @var string */
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function name() : string
    {
        return $this->name;
    }
}
