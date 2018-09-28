<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\Separator;

use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\Request;

final class Create implements Request
{
    private const TYPES = ['dashes', 'dots', 'morse_code', 'basic_line', 'wave', 'end_of_article'];

    /** @var string */
    private $type;

    /** @var string */
    private $colorHex;

    public function __construct(string $type, string $colorHex)
    {
        Assertion::inArray($type, self::TYPES);

        $this->type     = $type;
        $this->colorHex = $colorHex;
    }

    /** @inheritdoc */
    public function jsonSerialize() : array
    {
        return [
            'type' => $this->type,
            'colorHex' => $this->colorHex,
        ];
    }
}
