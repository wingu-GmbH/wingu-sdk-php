<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Component;

interface Component
{
    public function id() : string;

    public function updatedAt() : \DateTime;
}
