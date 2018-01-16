<?php

declare(strict_types = 1);

namespace Wingu\Engine\SDK\Hydrator;

use Psr\Http\Message\ResponseInterface;

interface Hydrator
{
    public function hydrateData(array $data, string $class);

    public function hydrateResponse(ResponseInterface $response, string $class);
}
