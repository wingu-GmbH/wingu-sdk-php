<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Content\Pack;

use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\Request;

final class Update implements Request
{
    private const LOCALES = ['en', 'de', 'pl', 'es'];

    /** @var string|null */
    private $locale;

    public function __construct(?string $locale = null)
    {
        Assertion::nullOrInArray($locale, self::LOCALES);

        $this->locale = $locale;
    }

    /** @inheritdoc */
    public function jsonSerialize() : array
    {
        return \array_filter([
            'locale' => $this->locale,
        ]);
    }
}
