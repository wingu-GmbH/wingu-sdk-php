<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\AudioPlaylist\Media;

use Psr\Http\Message\StreamInterface;
use Wingu\Engine\SDK\Model\Request\MultipartRequest;

final class Create implements MultipartRequest
{
    /** @var StreamInterface */
    private $media;

    /** @var string */
    private $name;

    public function __construct(StreamInterface $media, string $name)
    {
        $this->media = $media;
        $this->name  = $name;
    }

    /** @inheritdoc */
    public function jsonSerialize() : array
    {
        return [
            'name' => $this->name,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function files() : array
    {
        return [
            'media' => $this->media,
        ];
    }
}
