<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request;

use Psr\Http\Message\StreamInterface;

interface MultipartRequest extends Request
{
    /**
     * Array containing files to upload. It can be multidimensional.
     *
     * @return mixed[]|StreamInterface[]
     */
    public function files() : array;
}
