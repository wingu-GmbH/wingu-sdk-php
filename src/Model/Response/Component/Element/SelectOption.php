<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Component\Element;

final class SelectOption
{
    /** @var string */
    private $label;

    /** @var string */
    private $value;

    public function __construct(string $label, string $value)
    {
        $this->label = $label;
        $this->value = $value;
    }

    public function label() : string
    {
        return $this->label;
    }

    public function value() : string
    {
        return $this->value;
    }
}
