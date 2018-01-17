<?php

declare(strict_types = 1);

namespace Wingu\Engine\SDK\Model\Channel;

interface Channel
{
    public function id(): string;

    public function name(): string;
}
