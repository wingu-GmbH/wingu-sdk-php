<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\Files;

use Wingu\Engine\SDK\Model\Request\Request;

final class Create implements Request
{
    /** @inheritdoc */
    public function jsonSerialize() : array
    {
        return [];
    }
}
