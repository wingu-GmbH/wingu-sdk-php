<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component;

use Assert\Assert;
use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\Request;

class Copy implements Request
{
    /** @var string[] */
    private $decks;

    /**
     * @param string[] $decks
     */
    public function __construct(array $decks)
    {
        Assertion::notEmpty($decks);
        Assert::thatAll($decks)->uuid();

        $this->decks = $decks;
    }

    /** @inheritdoc */
    public function jsonSerialize() : array
    {
        return [
            'decks' => $this->decks,
        ];
    }
}
