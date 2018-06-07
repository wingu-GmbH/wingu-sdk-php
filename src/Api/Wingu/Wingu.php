<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Api\Wingu;

use Wingu\Engine\SDK\Api\Api;
use Wingu\Engine\SDK\Model\Response\Wingu\Ping\Ping;

final class Wingu extends Api
{
    public function ping() : Ping
    {
        $request = $this->createGetRequest('/api/wingu/ping.json');

        $response = $this->handleRequest($request);

        return $this->hydrator->hydrateResponse($response, Ping::class);
    }
}
