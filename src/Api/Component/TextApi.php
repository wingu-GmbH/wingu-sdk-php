<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Api\Component;

use Wingu\Engine\SDK\Api\Api;
use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\Component\Text\Create;
use Wingu\Engine\SDK\Model\Request\Component\Text\Update;
use Wingu\Engine\SDK\Model\Response\Component\Text;

final class TextApi extends Api
{
    public function create(Create $text) : Text
    {
        $request = $this->createPostRequest('/api/component/text', $text);

        $response = $this->handleRequest($request);

        return $this->hydrator->hydrateResponse($response, Text::class);
    }

    public function update(string $id, Update $text) : void
    {
        Assertion::uuid($id);
        $request = $this->createPatchRequest('/api/component/text/' . $id, $text);

        $this->handleRequest($request);
    }
}
