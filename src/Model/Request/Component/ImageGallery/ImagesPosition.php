<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\ImageGallery;

use Assert\Assert;
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
        Assert::thatAll($orderedImages)->uuid();

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
