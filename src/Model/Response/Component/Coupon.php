<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Component;

class Coupon implements Component
{
    use ComponentTrait;

    /** @var string|null */
    private $header;

    /** @var string */
    private $description;

    /** @var string|null */
    private $disclaimer;

    public function __construct(
        string $id,
        \DateTime $updatedAt,
        ?string $header,
        string $description,
        ?string $disclaimer
    ) {
        $this->id          = $id;
        $this->updatedAt   = $updatedAt;
        $this->header      = $header;
        $this->description = $description;
        $this->disclaimer  = $disclaimer;
    }

    public function getHeader() : ?string
    {
        return $this->header;
    }

    public function getDescription() : string
    {
        return $this->description;
    }

    public function getDisclaimer() : ?string
    {
        return $this->disclaimer;
    }
}
