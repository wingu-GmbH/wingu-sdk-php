<?php

declare(strict_types = 1);

namespace Wingu\Engine\SDK\Model\Content;

use Wingu\Engine\SDK\Assertion;

final class Locale
{
    private $name;

    private $code;

    public function __construct(string $name, string $code)
    {
        Assertion::notEmpty($name);
        Assertion::notEmpty($code);

        $this->name = $name;
        $this->code = $code;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function code(): string
    {
        return $this->code;
    }
}
