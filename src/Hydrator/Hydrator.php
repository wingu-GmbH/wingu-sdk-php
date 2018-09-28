<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Hydrator;

use Psr\Http\Message\ResponseInterface;

interface Hydrator
{
    /**
     * @param mixed[] $data
     *
     * @return mixed
     */
    public function hydrateData(array $data, string $class);

    /** @return mixed */
    public function hydrateResponse(ResponseInterface $response, string $class);
}
