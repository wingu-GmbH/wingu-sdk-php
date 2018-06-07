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

    /** @var null|string */
    private $description;

    /** @var Card[] */
    private $cards;

    /** @param Card[] $cards */
    public function __construct(string $id, string $title, ?string $description, array $cards)
    {
        Assertion::uuid($id);
        Assertion::notEmpty($title);

        $this->id          = $id;
        $this->title       = $title;
        $this->description = $description;
        $this->cards       = $cards;
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
}
