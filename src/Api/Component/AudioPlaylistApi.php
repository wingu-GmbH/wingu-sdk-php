<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Api\Component;

use Wingu\Engine\SDK\Api\Api;
use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\Component\AudioPlaylist\Create;
use Wingu\Engine\SDK\Model\Request\Component\AudioPlaylist\Media\Create as CreateMedia;
use Wingu\Engine\SDK\Model\Request\Component\AudioPlaylist\Media\Update as UpdateMedia;
use Wingu\Engine\SDK\Model\Request\Component\AudioPlaylist\MediaPosition;
use Wingu\Engine\SDK\Model\Request\Component\AudioPlaylist\Update;
use Wingu\Engine\SDK\Model\Response\Component\AudioPlaylist;
use Wingu\Engine\SDK\Model\Response\Component\AudioPlaylistMedia;

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

    public function createMedia(string $id, CreateMedia $media) : AudioPlaylistMedia
    {
        Assertion::uuid($id);
        $request = $this->createMultipartPostRequest('/api/component/audio_playlist/' . $id . '/media', $media);

        $response = $this->handleRequest($request);

        return $this->hydrator->hydrateResponse($response, AudioPlaylistMedia::class);
    }

    public function updateMedia(string $id, UpdateMedia $media) : void
    {
        Assertion::uuid($id);
        $request = $this->createPatchRequest('/api/component/audio_playlist/media/' . $id, $media);

        $this->handleRequest($request);
    }

    public function updateMediaPosition(string $id, MediaPosition $mediaPosition) : void
    {
        Assertion::uuid($id);
        $request = $this->createPutRequest('/api/component/audio_playlist/' . $id . '/media_position', $mediaPosition);

        $this->handleRequest($request);
    }

    public function deleteMedia(string $id) : void
    {
        Assertion::uuid($id);
        $request = $this->createDeleteRequest('/api/component/audio_playlist/media/' . $id);

        $this->handleRequest($request);
    }
}
