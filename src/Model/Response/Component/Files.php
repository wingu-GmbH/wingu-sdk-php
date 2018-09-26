<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Component;

use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Response\Component\FilesFile as File;

class Files implements Component
{
    use ComponentTrait;

    /** @var File[] */
    private $files;

    /**
     * @param File[] $files
     */
    public function __construct(string $id, \DateTime $updatedAt, array $files)
    {
        Assertion::allIsInstanceOf($files, File::class);

        $this->id        = $id;
        $this->updatedAt = $updatedAt;
        $this->files     = $files;
    }

    /** @return File[] */
    public function files() : array
    {
        return $this->files;
    }
}
