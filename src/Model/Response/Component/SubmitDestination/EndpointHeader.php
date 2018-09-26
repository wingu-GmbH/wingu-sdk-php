<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Component\SubmitDestination;

final class EndpointHeader
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

    public function name() : string
    {
        return $this->name;
    }

    public function value() : string
    {
        return $this->value;
    }
}
