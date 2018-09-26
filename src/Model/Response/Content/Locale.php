<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Content;

use Wingu\Engine\SDK\Assertion;

final class Locale
{
    private const CODES = ['de', 'en', 'es', 'pl'];

    /** @var string */
    private $name;

    /** @var string */
    private $code;

    public function __construct(string $name, string $code)
    {
        Assertion::notEmpty($name);
        Assertion::notEmpty($code);
        Assertion::inArray($code, self::CODES);

        $this->name = $name;
        $this->code = $code;
    }

    public function name() : string
    {
        return $this->name;
    }

    public function code() : string
    {
        return $this->code;
    }
}
