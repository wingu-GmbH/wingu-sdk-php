<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\ImageGallery\Image;

use Wingu\Engine\SDK\Model\Request\Request;

final class Update implements Request
{
    /** @var int|null */
    private $positionSort;

    /** @var string|null */
    private $caption;

    public function __construct(?int $positionSort, ?string $caption)
    {
        $this->positionSort = $positionSort;
        $this->caption      = $caption;
    }

    /** @inheritdoc */
    public function jsonSerialize() : array
    {
        return [
            'positionSort' => $this->positionSort,
            'caption' => $this->caption,
        ];
    }
}
