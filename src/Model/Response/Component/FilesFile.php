<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Component;

class FilesFile
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
    private $size;

    public function __construct(string $id, int $position, string $fileUrl, string $name, int $size)
    {
        $this->id       = $id;
        $this->position = $position;
        $this->fileUrl  = $fileUrl;
        $this->name     = $name;
        $this->size     = $size;
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

    public function size() : int
    {
        return $this->size;
    }
}
