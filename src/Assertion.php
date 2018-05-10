<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK;

use Assert\Assertion as BaseAssertion;
use Wingu\Engine\SDK\Exception\AssertInvalidArgument;

final class Assertion extends BaseAssertion
{
    /** @var string */
    protected static $exceptionClass = AssertInvalidArgument::class;
}
