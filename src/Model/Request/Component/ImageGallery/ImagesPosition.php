<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\ImageGallery;

use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\Request;

final class ImagesPosition implements Request
{
    /** @var string[] */
    private $orderedImages;

    /** @param string[] $orderedImages */
    public function __construct(array $orderedImages)
    {
        Assertion::notEmpty($orderedImages);
        foreach ($orderedImages as $image) {
            Assertion::uuid($image);
        }
        $this->orderedImages = $orderedImages;
    }

    /** @inheritdoc */
    public function jsonSerialize() : array
    {
        return [
            'orderedImages' => $this->orderedImages,
        ];
    }
}
