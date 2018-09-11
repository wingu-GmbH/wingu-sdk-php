<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Api\Component;

use Wingu\Engine\SDK\Api\Api;
use Wingu\Engine\SDK\Model\Request\Component\Files\Create;
use Wingu\Engine\SDK\Model\Response\Component\Files;

final class FilesApi extends Api
{
    public function create(Create $files) : Files
    {
        $request = $this->createPostRequest('/api/component/files', $files);

        $response = $this->handleRequest($request);

        return $this->hydrator->hydrateResponse($response, Files::class);
    }
}
