<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Component\Element;

interface Element
{
    public function name() : string;

    public function label() : string;

    public function required() : bool;

    public function persistent() : bool;
}
