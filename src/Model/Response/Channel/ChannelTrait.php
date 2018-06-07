<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Channel;

trait ChannelTrait
{
    /** @var string */
    private $id;

    /** @var string */
    private $name;

    public function id() : string
    {
        return $this->id;
    }

    public function name() : string
    {
        return $this->name;
    }
}
