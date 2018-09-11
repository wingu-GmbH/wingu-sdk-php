<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Api\Component;

use Wingu\Engine\SDK\Api\Api;
use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\Component\Action\Create;
use Wingu\Engine\SDK\Model\Request\Component\Action\Update;
use Wingu\Engine\SDK\Model\Response\Component\Action;

final class ActionApi extends Api
{
    public function create(Create $action) : Action
    {
        $request = $this->createPostRequest('/api/component/action', $action);

        $response = $this->handleRequest($request);

        return $this->hydrator->hydrateResponse($response, Action::class);
    }

    public function update(string $id, Update $action) : void
    {
        Assertion::uuid($id);
        $request = $this->createPatchRequest('/api/component/action/' . $id, $action);

        $this->handleRequest($request);
    }
}
