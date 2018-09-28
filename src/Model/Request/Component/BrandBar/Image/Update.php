<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\BrandBar\Image;

use Psr\Http\Message\StreamInterface;
use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\MultipartRequest;

final class Update implements MultipartRequest
{
    private const ALIGNMENT = ['left', 'center', 'right'];

    /** @var string|null */
    private $alignment;

    /** @var StreamInterface|null */
    private $image;

    public function __construct(?string $alignment = null, ?StreamInterface $image = null)
    {
        Assertion::nullOrInArray($alignment, self::ALIGNMENT);
        $this->alignment = $alignment;
        $this->image     = $image;
    }

    /** @inheritdoc */
    public function jsonSerialize() : array
    {
        return \array_filter([
            'alignment' => $this->alignment,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function files() : array
    {
        if ($this->image === null) {
            return [];
        }

        return [
            'image' => $this->image,
        ];
    }
}
