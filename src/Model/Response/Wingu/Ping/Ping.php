<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Wingu\Ping;

final class Ping
{
    /** @var Cloudinary */
    private $cloudinary;

    /** @var Version */
    private $version;

    public function __construct(Cloudinary $cloudinary, Version $version)
    {
        $this->cloudinary = $cloudinary;
        $this->version    = $version;
    }

    public function cloudinary() : Cloudinary
    {
        return $this->cloudinary;
    }

    public function version() : Version
    {
        return $this->version;
    }
}
