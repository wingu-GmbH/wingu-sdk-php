<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Content;

use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Response\Card\Card;

final class Deck
{
    /** @var string */
    private $id;

    /** @var string */
    private $title;

    /** @var string|null */
    private $description;

    /** @var Card[] */
    private $cards;

    /** @var string|null */
    private $legalNote;

    /**
     * @param Card[] $cards
     */
    public function __construct(string $id, string $title, ?string $description, array $cards, ?string $legalNote)
    {
        Assertion::uuid($id);
        Assertion::notEmpty($title);
        Assertion::allIsInstanceOf($cards, Card::class);

        $this->id          = $id;
        $this->title       = $title;
        $this->description = $description;
        $this->cards       = $cards;
        $this->legalNote   = $legalNote;
    }

    public function id() : string
    {
        return $this->id;
    }

    public function title() : string
    {
        return $this->title;
    }

    public function description() : ?string
    {
        return $this->description;
    }

    /**
     * @return Card[]
     */
    public function cards() : array
    {
        return $this->cards;
    }

    public function legalNote() : ?string
    {
        return $this->legalNote;
    }
}
