<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Api\Component;

use Wingu\Engine\SDK\Api\Api;
use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\Component\Proxy\Create;
use Wingu\Engine\SDK\Model\Request\Component\Proxy\Update;
use Wingu\Engine\SDK\Model\Response\Component\Proxy;

final class ProxyApi extends Api
{
    public function create(Create $proxy) : Proxy
    {
        $request = $this->createPostRequest('/api/component/proxy', $proxy);

        $response = $this->handleRequest($request);

        return $this->hydrator->hydrateResponse($response, Proxy::class);
    }

    public function update(string $id, Update $proxy) : void
    {
        Assertion::uuid($id);
        $request = $this->createPatchRequest('/api/component/proxy/' . $id, $proxy);

        $this->handleRequest($request);
    }
}
