<?php

declare(strict_types = 1);

namespace Wingu\Engine\SDK;

use Assert\Assertion as BaseAssertion;
use Wingu\Engine\SDK\Exception\AssertInvalidArgumentException;

final class Assertion extends BaseAssertion
{
    protected static $exceptionClass = AssertInvalidArgumentException::class;
}
