<?php

declare(strict_types = 1);

namespace Wingu\Engine\SDK\Model\Content;

use Wingu\Engine\SDK\Assertion;

final class Category
{
    private $id;

    private $name;

    private $colorHex;

    public function __construct(int $id, string $name, string $colorHex)
    {
        Assertion::min($id, 1);
        Assertion::notEmpty($name);
        Assertion::length($colorHex, 6);

        $this->id = $id;
        $this->name = $name;
        $this->colorHex = $colorHex;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function colorHex(): string
    {
        return $this->colorHex;
    }
}
