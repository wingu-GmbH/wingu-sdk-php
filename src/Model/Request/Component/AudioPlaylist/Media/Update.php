<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\AudioPlaylist\Media;

use Wingu\Engine\SDK\Model\Request\Request;

final class Update implements Request
{
    /** @var int|null */
    private $positionSort;

    /** @var string|null */
    private $name;

    public function __construct(?int $positionSort = null, ?string $name = null)
    {
        $this->positionSort = $positionSort;
        $this->name         = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize() : array
    {
        return \array_filter([
            'positionSort' => $this->positionSort,
            'name' => $this->name,
        ]);
    }
}
