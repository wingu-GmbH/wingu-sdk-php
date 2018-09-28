<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\ImageGallery\Image;

use Wingu\Engine\SDK\Model\Request\Request;
use Wingu\Engine\SDK\Model\Request\StringValue;

final class Update implements Request
{
    /** @var int|null */
    private $positionSort;

    /** @var StringValue|null */
    private $caption;

    public function __construct(?int $positionSort = null, ?StringValue $caption = null)
    {
        $this->positionSort = $positionSort;
        $this->caption      = $caption;
    }

    /** @inheritdoc */
    public function jsonSerialize() : array
    {
        return \array_filter([
            'positionSort' => $this->positionSort,
            'caption' => $this->caption,
        ]);
    }
}
