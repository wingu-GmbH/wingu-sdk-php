<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Component;

class CouponBarcode
{
    /** @var string */
    private $type;

    /** @var string */
    private $value;

    public function __construct(string $type, string $value)
    {
        $this->type  = $type;
        $this->value = $value;
    }

    public function type() : string
    {
        return $this->type;
    }

    public function value() : string
    {
        return $this->value;
    }
}
