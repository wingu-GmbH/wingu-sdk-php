<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Wingu\Ping;

use Wingu\Engine\SDK\Assertion;

final class Version
{
    /** @var string */
    private $current;

    public function __construct(string $current)
    {
        Assertion::notEmpty($current);

        $this->current = $current;
    }

    public function current() : string
    {
        return $this->current;
    }
}
