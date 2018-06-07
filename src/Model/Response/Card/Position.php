<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Card;

final class Position
{
    /** @var int */
    private $sort;

    public function __construct(int $sort)
    {
        $this->sort = $sort;
    }

    public function sort() : int
    {
        return $this->sort;
    }
}
