<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\Form\Element;

use Wingu\Engine\SDK\Assertion;

final class Input implements Element
{
    private const TYPES = ['text', 'email', 'url', 'date', 'datetime', 'time'];

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
        Assertion::inArray($type, self::TYPES);
        $this->name     = $name;
        $this->label    = $label;
        $this->required = $required;
        $this->type     = $type;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize() : array
    {
        return [
            'name'          => $this->name,
            'label'         => $this->label,
            'required'      => $this->required,
            'type'          => $this->type,
            'discriminator' => 'input',
        ];
    }
}
