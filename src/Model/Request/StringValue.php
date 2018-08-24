<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request;

final class StringValue implements \JsonSerializable
{
    /** @var string|null */
    private $value;

    public function __construct(?string $value)
    {
        $this->value = $value;
    }

    public function value() : ?string
    {
        return $this->value;
    }

    public function jsonSerialize() : ?string
    {
        return $this->value;
    }
}
