<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Exception;

use Assert\InvalidArgumentException;
use Wingu\Engine\SDK\Exception;

final class AssertInvalidArgument extends InvalidArgumentException implements Exception
{
}
