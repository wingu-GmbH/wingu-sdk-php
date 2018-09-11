<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\Coupon\Barcode;

use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\Request;

final class Update implements Request
{
    private const TYPES = ['EAN_13'];

    /** @var string */
    private $type;

    /** @var string */
    private $description;

    public function __construct(string $type, string $description)
    {
        Assertion::inArray($type, self::TYPES);
        $this->type        = $type;
        $this->description = $description;
    }

    /** @inheritdoc */
    public function jsonSerialize()
    {
        return [
            'type' => $this->type,
            'description' => $this->description,
        ];
    }
}
