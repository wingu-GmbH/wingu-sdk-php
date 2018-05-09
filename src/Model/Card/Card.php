<?php

declare(strict_types = 1);

namespace Wingu\Engine\SDK\Model\Card;

final class Card
{
    private $id;

    private $position;

    public function __construct(string $id, Position $position)
    {
        $this->id = $id;
        $this->position = $position;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function position(): Position
    {
        return $this->position;
    }
}
