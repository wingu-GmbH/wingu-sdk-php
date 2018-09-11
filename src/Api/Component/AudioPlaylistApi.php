<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Api\Component;

use Wingu\Engine\SDK\Api\Api;
use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\Component\AudioPlaylist\Create;
use Wingu\Engine\SDK\Model\Request\Component\AudioPlaylist\Update;
use Wingu\Engine\SDK\Model\Response\Component\AudioPlaylist;

final class AudioPlaylistApi extends Api
{
    public function create(Create $audioPlaylist) : AudioPlaylist
    {
        $request = $this->createPostRequest('/api/component/audio_playlist', $audioPlaylist);

        $response = $this->handleRequest($request);

        return $this->hydrator->hydrateResponse($response, AudioPlaylist::class);
    }

    public function update(string $id, Update $audioPlaylist) : void
    {
        Assertion::uuid($id);
        $request = $this->createPatchRequest('/api/component/audio_playlist/' . $id, $audioPlaylist);

        $this->handleRequest($request);
    }
}
