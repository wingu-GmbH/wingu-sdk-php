<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Component\Element;

final class Input implements Element
{
    /** @var string */
    private $name;

    /** @var string */
    private $label;

    /** @var bool */
    private $required;

    /** @var string */
    private $type;

    public function __construct(string $name, string $label, bool $required, string $type)
    {
        $this->name     = $name;
        $this->label    = $label;
        $this->required = $required;
        $this->type     = $type;
    }

    public function name() : string
    {
        return $this->name;
    }

    public function label() : string
    {
        return $this->label;
    }

    public function required() : bool
    {
        return $this->required;
    }

    public function type() : string
    {
        return $this->type;
    }
}
