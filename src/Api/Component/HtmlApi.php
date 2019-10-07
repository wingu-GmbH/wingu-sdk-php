<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Api\Component;

use Wingu\Engine\SDK\Api\Api;
use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\Component\Html\Create;
use Wingu\Engine\SDK\Model\Request\Component\Html\Update;
use Wingu\Engine\SDK\Model\Response\Component\Html;

final class HtmlApi extends Api
{
    public function create(Create $html) : Html
    {
        $request = $this->createPostRequest('/api/component/my/html', $html);

        $response = $this->handleRequest($request);

        return $this->hydrator->hydrateResponse($response, Html::class);
    }

    public function update(string $id, Update $html) : void
    {
        Assertion::uuid($id);
        $request = $this->createPatchRequest('/api/component/my/html/' . $id, $html);

        $this->handleRequest($request);
    }
}
