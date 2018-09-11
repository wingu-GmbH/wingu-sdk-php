<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Api\Component;

use Wingu\Engine\SDK\Api\Api;
use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\Component\Separator\Create;
use Wingu\Engine\SDK\Model\Request\Component\Separator\Update;
use Wingu\Engine\SDK\Model\Response\Component\Separator;

final class SeparatorApi extends Api
{
    public function create(Create $separator) : Separator
    {
        $request = $this->createPostRequest('/api/component/separator', $separator);

        $response = $this->handleRequest($request);

        return $this->hydrator->hydrateResponse($response, Separator::class);
    }

    public function update(string $id, Update $separator) : void
    {
        Assertion::uuid($id);
        $request = $this->createPatchRequest('/api/component/separator/' . $id, $separator);

        $this->handleRequest($request);
    }
}
