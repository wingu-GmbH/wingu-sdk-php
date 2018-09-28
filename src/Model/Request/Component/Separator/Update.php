<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\Separator;

use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\Request;

final class Update implements Request
{
    private const TYPES = ['dashes', 'dots', 'morse_code', 'basic_line', 'wave', 'end_of_article'];

    /** @var string|null */
    private $type;

    /** @var string|null */
    private $colorHex;

    public function __construct(?string $type = null, ?string $colorHex = null)
    {
        Assertion::nullOrInArray($type, self::TYPES);

        $this->type     = $type;
        $this->colorHex = $colorHex;
    }

    /** @inheritdoc */
    public function jsonSerialize() : array
    {
        return \array_filter([
            'type' => $this->type,
            'colorHex' => $this->colorHex,
        ]);
    }
}
