<?php

declare(strict_types = 1);

namespace Wingu\Engine\SDK\Model\Content;

use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Card\Card;
use Wingu\Engine\SDK\Model\Card\CardCollection;

final class Deck
{
    private $id;

    private $title;

    private $description;

    private $cards;

    public function __construct(string $id, string $title, ?string $description, CardCollection $cards)
    {
        Assertion::uuid($id);
        Assertion::notEmpty($title);

        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->cards = $cards;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function description(): ?string
    {
        return $this->description;
    }

    /**
     * @return CardCollection|Card[]
     */
    public function cards(): CardCollection
    {
        return $this->cards;
    }
}
