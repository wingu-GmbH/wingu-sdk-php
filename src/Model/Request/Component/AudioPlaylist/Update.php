<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\AudioPlaylist;

use Wingu\Engine\SDK\Model\Request\Request;
use Wingu\Engine\SDK\Model\Request\StringValue;

final class Update implements Request
{
    /** @var StringValue|null */
    private $name;

    public function __construct(?StringValue $name = null)
    {
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize() : array
    {
        return \array_filter([
            'name' => $this->name,
        ]);
    }
}
