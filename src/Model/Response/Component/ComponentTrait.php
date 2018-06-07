<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Component;

trait ComponentTrait
{
    /** @var string */
    private $id;

    /** @var \DateTime */
    private $updatedAt;

    public function id() : string
    {
        return $this->id;
    }

    public function updatedAt() : \DateTime
    {
        return $this->updatedAt;
    }
}
