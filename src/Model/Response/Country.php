<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response;

use Wingu\Engine\SDK\Assertion;

final class Country
{
    /** @var string */
    private $iso31661Alpha2;

    /** @var string */
    private $name;

    public function __construct(string $iso31661Alpha2, string $name)
    {
        Assertion::length($iso31661Alpha2, 2);
        Assertion::notEmpty($name);

        $this->iso31661Alpha2 = \strtoupper($iso31661Alpha2);
        $this->name           = $name;
    }

    public function iso31661Alpha2() : string
    {
        return $this->iso31661Alpha2;
    }

    public function name() : string
    {
        return $this->name;
    }
}
