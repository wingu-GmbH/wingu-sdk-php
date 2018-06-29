<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Content;

use Wingu\Engine\SDK\Assertion;

final class Pack
{
    /** @var string */
    private $id;

    /** @var Deck */
    private $deck;

    /** @var Locale */
    private $locale;

    public function __construct(string $id, Deck $deck, Locale $locale)
    {
        Assertion::uuid($id);

        $this->id     = $id;
        $this->deck   = $deck;
        $this->locale = $locale;
    }

    public function id() : string
    {
        return $this->id;
    }

    public function deck() : Deck
    {
        return $this->deck;
    }

    public function locale() : Locale
    {
        return $this->locale;
    }
}