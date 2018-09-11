<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\BrandBar\Image;

use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\Request;

final class Create implements Request
{
    private const ALIGNMENT = ['left', 'center', 'right'];

    /** @var string */
    private $alignment;

    /** todo: File
     * private $image;
     */
    public function __construct(string $alignment)
    {
        Assertion::inArray($alignment, self::ALIGNMENT);
        $this->alignment = $alignment;
    }

    /** @inheritdoc */
    public function jsonSerialize() : array
    {
        return [
            'alignment' => $this->alignment,
        ];
    }
}
