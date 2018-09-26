<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\Form\Element;

use Wingu\Engine\SDK\Model\Request\Request;

final class SelectOption implements Request
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

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize() : array
    {
        return [
            'label' => $this->label,
            'value' => $this->value,
        ];
    }
}
