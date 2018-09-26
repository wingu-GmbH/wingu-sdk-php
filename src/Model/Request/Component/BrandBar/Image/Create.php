<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\BrandBar\Image;

use Psr\Http\Message\StreamInterface;
use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\MultipartRequest;

final class Create implements MultipartRequest
{
    private const ALIGNMENT = ['left', 'center', 'right'];

    /** @var string */
    private $alignment;

    /** @var StreamInterface */
    private $image;

    public function __construct(string $alignment, StreamInterface $image)
    {
        Assertion::inArray($alignment, self::ALIGNMENT);
        $this->alignment = $alignment;
        $this->image     = $image;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize() : array
    {
        return [
            'alignment' => $this->alignment,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function files() : array
    {
        return [
            'image' => $this->image,
        ];
    }
}
