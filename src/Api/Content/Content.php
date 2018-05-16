<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Api\Content;

use Wingu\Engine\SDK\Api\Api;
use Wingu\Engine\SDK\Model\Content\PrivateContent;

final class Content extends Api
{
    public function myContent(string $id) : PrivateContent
    {
        $request = $this->createGetRequest('/api/content/my/' . $id . '.json');

        $response = $this->handleRequest($request);

        return $this->hydrator->hydrateResponse($response, PrivateContent::class);
    }
}
