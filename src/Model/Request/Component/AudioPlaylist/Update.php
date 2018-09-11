<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\AudioPlaylist;

use Wingu\Engine\SDK\Model\Request\Request;

final class Update implements Request
{
    /** @var string|null */
    private $name;

    public function __construct(?string $name)
    {
        $this->name = $name;
    }

    /** @inheritdoc */
    public function jsonSerialize() : array
    {
        return [
            'name' => $this->name,
        ];
    }
}
