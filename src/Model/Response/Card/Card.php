<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Card;

use Wingu\Engine\SDK\Model\Response\Component\Component;

final class Card
{
    /** @var string */
    private $id;

    /** @var Position */
    private $position;

    /** @var Component */
    private $component;

    public function __construct(string $id, Position $position, Component $component)
    {
        $this->id        = $id;
        $this->position  = $position;
        $this->component = $component;
    }

    public function id() : string
    {
        return $this->id;
    }

    public function position() : Position
    {
        return $this->position;
    }

    public function component() : Component
    {
        return $this->component;
    }
}
