<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Component\Element;

use Wingu\Engine\SDK\Assertion;

final class Select implements Element
{
    /** @var string */
    private $name;

    /** @var string */
    private $label;

    /** @var bool */
    private $required;

    /** @var bool */
    private $multiple;

    /** @var SelectOption[] */
    private $options;

    /** @param SelectOption[] $options */
    public function __construct(string $name, string $label, bool $required, bool $multiple, array $options)
    {
        Assertion::allIsInstanceOf($options, SelectOption::class);
        $this->name     = $name;
        $this->label    = $label;
        $this->required = $required;
        $this->multiple = $multiple;
        $this->options  = $options;
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

    public function multiple() : bool
    {
        return $this->multiple;
    }

    /** @return SelectOption[] */
    public function options() : array
    {
        return $this->options;
    }
}
