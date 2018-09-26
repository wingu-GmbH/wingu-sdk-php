<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\Form\SubmitDestination;

use Wingu\Engine\SDK\Model\Request\Request;

final class EndpointHeader implements Request
{
    /** @var string */
    private $name;

    /** @var string */
    private $value;

    public function __construct(string $name, string $value)
    {
        $this->name  = $name;
        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize() : array
    {
        return [
            $this->name => $this->value,
        ];
    }
}
