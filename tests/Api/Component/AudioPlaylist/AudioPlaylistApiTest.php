<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Tests\Api\Component\AudioPlaylist;

use GuzzleHttp\Psr7\Response;
use Http\Mock\Client as MockClient;
use Psr\Http\Message\RequestInterface;
use Wingu\Engine\SDK\Api\Component\AudioPlaylistApi;
use Wingu\Engine\SDK\Api\Configuration;
use Wingu\Engine\SDK\Model\Request\Component\AudioPlaylist\Create;
use Wingu\Engine\SDK\Model\Request\Component\AudioPlaylist\Media\Create as CreateMedia;
use Wingu\Engine\SDK\Model\Request\Component\AudioPlaylist\Media\Update as UpdateMedia;
use Wingu\Engine\SDK\Model\Request\Component\AudioPlaylist\MediaPosition;
use Wingu\Engine\SDK\Model\Request\Component\AudioPlaylist\Update;
use Wingu\Engine\SDK\Model\Request\StringValue;
use Wingu\Engine\SDK\Model\Response\Component\AudioPlaylist;
use Wingu\Engine\SDK\Model\Response\Component\AudioPlaylistMedia;
use Wingu\Engine\SDK\Tests\Api\ApiTest;

class AudioPlaylistApiTest extends ApiTest
{
    public function testCreateReturnsNewAudioPlaylistComponent() : void
    {
        $configurationMock = new Configuration();

        $httpClient = new MockClient();
        $response   = new Response(
            201,
            ['Content-Type' => 'application/json'],
            $this->getDataFromFixturesFile('posted_audio_playlist_component.json')
        );
        $httpClient->addResponse($response);

        $winguApi = new AudioPlaylistApi($configurationMock, $httpClient);

        $actualResponse = $winguApi->create(
            new Create(
                'playlist name'
            )
        );

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();
        self::assertSame('{"name":"playlist name"}', $actualRequest->getBody()->getContents());
        self::assertSame('POST', $actualRequest->getMethod());

        $expectedResponse = $this->getExpectedAudioPlaylist();
        self::assertEquals($expectedResponse, $actualResponse);
    }

    public function testUpdatePatchesAudioPlaylistComponent() : void
    {
        $configurationMock = new Configuration();

        $httpClient = new MockClient();
        $response   = new Response(
            204,
            ['Content-Type' => 'application/json']
        );
        $httpClient->addResponse($response);

        $winguApi = new AudioPlaylistApi($configurationMock, $httpClient);

        $winguApi->update(
            'b75ea792-07fe-427f-a1b5-867e25a29c23',
            new Update(
                new StringValue('updated playlist name')
            )
        );

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();
        self::assertSame('{"name":"updated playlist name"}', $actualRequest->getBody()->getContents());
        self::assertSame('PATCH', $actualRequest->getMethod());
    }

    public function testCreateMediaReturnsNewAudioPlaylistMedia() : void
    {
        $configurationMock = new Configuration();

        $httpClient = new MockClient();
        $response   = new Response(
            201,
            ['Content-Type' => 'application/json'],
            $this->getDataFromFixturesFile('posted_audio_playlist_media.json')
        );
        $httpClient->addResponse($response);

        $winguApi = new AudioPlaylistApi($configurationMock, $httpClient);

        $actualResponse = $winguApi->createMedia(
            '55d9a8ec-87dc-41c9-a4fe-1b8d5603e004',
            new CreateMedia(
                \GuzzleHttp\Psr7\stream_for(\fopen('examples/audio_media.mp3', 'rb')),
                'media name'
            )
        );

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();

        self::assertStringStartsWith('multipart/form-data; boundary="', $actualRequest->getHeaderLine('Content-Type'));
        self::assertEquals(365184, $actualRequest->getBody()->getSize());
        self::assertSame('POST', $actualRequest->getMethod());

        $expectedResponse = $this->getExpectedAudioPlaylistMedia();
        self::assertEquals($expectedResponse, $actualResponse);
        self::assertSame('http://example.com/wingu-dev-components/audioplaylist/audio_media.mp3', $expectedResponse->fileUrl());
    }

    public function testUpdateMediaPatchesAudioPlaylistMedia() : void
    {
        $configurationMock = new Configuration();

        $httpClient = new MockClient();
        $response   = new Response(
            204,
            ['Content-Type' => 'application/json']
        );
        $httpClient->addResponse($response);

        $winguApi = new AudioPlaylistApi($configurationMock, $httpClient);

        $winguApi->updateMedia(
            'b0c6ace5-5448-4ed2-b124-b262823e8d2d',
            new UpdateMedia(
                1,
                'updated media name'
            )
        );

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();
        self::assertSame('{"positionSort":1,"name":"updated media name"}', $actualRequest->getBody()->getContents());
        self::assertSame('PATCH', $actualRequest->getMethod());
    }

    public function testUpdateMediaPositionPatchesAudioPlaylistMediaPosition() : void
    {
        $configurationMock = new Configuration();

        $httpClient = new MockClient();
        $response   = new Response(
            204,
            ['Content-Type' => 'application/json']
        );
        $httpClient->addResponse($response);

        $winguApi = new AudioPlaylistApi($configurationMock, $httpClient);

        $winguApi->updateMediaPosition(
            'b0c6ace5-5448-4ed2-b124-b262823e8d2d',
            new MediaPosition([
                '3c25ad37-63b7-431f-ae56-a7c7820aa631',
                '7082c56b-8d93-4b19-b6a5-df0c5d0d282d',
            ])
        );

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();
        self::assertSame(
            '{"orderedMedia":["3c25ad37-63b7-431f-ae56-a7c7820aa631","7082c56b-8d93-4b19-b6a5-df0c5d0d282d"]}',
            $actualRequest->getBody()->getContents()
        );
        self::assertSame('PUT', $actualRequest->getMethod());
    }

    public function testDeleteMediaRemovesAudioPlaylistMedia() : void
    {
        $configurationMock = new Configuration();

        $httpClient = new MockClient();
        $response   = new Response(
            204,
            ['Content-Type' => 'application/json']
        );
        $httpClient->addResponse($response);

        $winguApi = new AudioPlaylistApi($configurationMock, $httpClient);

        $winguApi->deleteMedia('b0c6ace5-5448-4ed2-b124-b262823e8d2d');

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();
        self::assertSame('', $actualRequest->getBody()->getContents());
        self::assertSame('DELETE', $actualRequest->getMethod());
    }

    private function getExpectedAudioPlaylist() : AudioPlaylist
    {
        return new AudioPlaylist(
            'b75ea792-07fe-427f-a1b5-867e25a29c23',
            new \DateTime('2018-09-05T11:04:19+0000'),
            'playlist name',
            []
        );
    }

    private function getExpectedAudioPlaylistMedia() : AudioPlaylistMedia
    {
        return new AudioPlaylistMedia(
            'b0c6ace5-5448-4ed2-b124-b262823e8d2d',
            2,
            'http://example.com/wingu-dev-components/audioplaylist/audio_media.mp3',
            'media name',
            3,
            null
        );
    }
}
