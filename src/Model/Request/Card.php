<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request;

use Wingu\Engine\SDK\Assertion;

final class Card implements Request
{
    /** @var string */
    private $deck;

    /** @var string */
    private $component;

    /** @var int|null */
    private $positionSort;

    public function __construct(string $deck, string $component, ?int $positionSort)
    {
        Assertion::uuid($deck);
        Assertion::uuid($component);
        $this->deck         = $deck;
        $this->component    = $component;
        $this->positionSort = $positionSort;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize() : array
    {
        return [
            'deck' => $this->deck,
            'component' => $this->component,
            'positionSort' => $this->positionSort,
        ];
    }
}
