<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\Files\File;

use Psr\Http\Message\StreamInterface;
use Wingu\Engine\SDK\Model\Request\MultipartRequest;

final class Create implements MultipartRequest
{
    /** @var StreamInterface */
    private $file;

    /** @var string */
    private $name;

    public function __construct(StreamInterface $file, string $name)
    {
        $this->file = $file;
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
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
            'file' => $this->file,
        ];
    }
}
