<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Api\Component;

use Wingu\Engine\SDK\Api\Api;
use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\Component\Video\Create;
use Wingu\Engine\SDK\Model\Request\Component\Video\Update;
use Wingu\Engine\SDK\Model\Response\Component\Video;

final class VideoApi extends Api
{
    public function create(Create $video) : Video
    {
        $request = $this->createPostRequest('/api/component/video', $video);

        $response = $this->handleRequest($request);

        return $this->hydrator->hydrateResponse($response, Video::class);
    }

    public function update(string $id, Update $video) : void
    {
        Assertion::uuid($id);
        $request = $this->createPatchRequest('/api/component/video/' . $id, $video);

        $this->handleRequest($request);
    }
}
