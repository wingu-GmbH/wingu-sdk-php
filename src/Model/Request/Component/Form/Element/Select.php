<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\Form\Element;

use Assert\Assertion;

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

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize() : array
    {
        return [
            'name'     => $this->name,
            'label'    => $this->label,
            'required' => $this->required,
            'multiple' => $this->multiple,
            'options'  => $this->options,
            'discriminator' => 'select',
        ];
    }
}
