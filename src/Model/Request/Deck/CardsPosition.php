<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Deck;

use Assert\Assert;
use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\Request;

final class CardsPosition implements Request
{
    /** @var string[] */
    private $orderedCards;

    /** @param string[] $orderedCards */
    public function __construct(array $orderedCards)
    {
        Assertion::notEmpty($orderedCards);
        Assert::thatAll($orderedCards)->uuid();

        $this->orderedCards = $orderedCards;
    }
    /** @inheritdoc */
    public function jsonSerialize() : array
    {
        return [
            'orderedCards' => $this->orderedCards,
        ];
    }
}
