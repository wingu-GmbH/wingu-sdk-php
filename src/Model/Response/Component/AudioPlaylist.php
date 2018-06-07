<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Component;

use Wingu\Engine\SDK\Model\Response\Component\AudioPlaylistMedia as Media;

final class AudioPlaylist implements Component
{
    use ComponentTrait;

    /** @var string|null */
    private $name;

    /** @var Media[] */
    private $media;

    /** @param Media[] $media */
    public function __construct(string $id, \DateTime $updatedAt, ?string $name, array $media)
    {
        $this->id        = $id;
        $this->updatedAt = $updatedAt;
        $this->name      = $name;
        $this->media     = $media;
    }

    public function name() : ?string
    {
        return $this->name;
    }

    /** @return Media[] */
    public function media() : array
    {
        return $this->media;
    }
}
