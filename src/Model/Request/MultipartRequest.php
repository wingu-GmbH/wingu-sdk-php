<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request;

use Psr\Http\Message\StreamInterface;

interface MultipartRequest extends Request
{
    /**
     * @return StreamInterface[]
     */
    public function files() : array;
}
