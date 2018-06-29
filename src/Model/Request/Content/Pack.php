<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Content;

use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\Request;

final class Pack implements Request
{
    private const LOCALES = ['en', 'de', 'pl', 'es'];

    /** @var string */
    private $content;

    /** @var string */
    private $deck;

    /** @var string */
    private $locale;

    public function __construct(string $content, string $deck, string $locale)
    {
        Assertion::uuid($content);
        Assertion::uuid($deck);
        Assertion::inArray($locale, self::LOCALES);
        $this->content = $content;
        $this->deck    = $deck;
        $this->locale  = $locale;
    }

    /** @inheritdoc */
    public function jsonSerialize()
    {
        return [
            'content' => $this->content,
            'deck' => $this->deck,
            'locale' => $this->locale,
        ];
    }
}
