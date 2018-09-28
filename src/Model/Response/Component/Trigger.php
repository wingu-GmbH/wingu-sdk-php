<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Component;

class Trigger
{
    /** @var bool */
    private $successful;

    public function __construct(bool $successful)
    {
        $this->successful = $successful;
    }

    public function successful() : bool
    {
        return $this->successful;
    }
}
