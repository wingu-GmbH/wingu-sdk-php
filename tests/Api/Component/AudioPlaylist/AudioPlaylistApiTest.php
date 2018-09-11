<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Tests\Api\Component\AudioPlaylist;

use GuzzleHttp\Psr7\Response;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use Http\Mock\Client as MockClient;
use Psr\Http\Message\RequestInterface;
use Wingu\Engine\SDK\Api\Component\AudioPlaylistApi;
use Wingu\Engine\SDK\Api\Configuration;
use Wingu\Engine\SDK\Hydrator\SymfonySerializerHydrator;
use Wingu\Engine\SDK\Model\Request\Component\AudioPlaylist\Create;
use Wingu\Engine\SDK\Model\Request\Component\AudioPlaylist\Update;
use Wingu\Engine\SDK\Model\Response\Component\AudioPlaylist;
use Wingu\Engine\SDK\Tests\Api\ApiTest;

class AudioPlaylistApiTest extends ApiTest
{
    public function testCreateReturnsNewAudioPlaylistComponent() : void
    {
        $configurationMock = new Configuration();
        $requestFactory    = new GuzzleMessageFactory();
        $hydrator          = new SymfonySerializerHydrator();

        $httpClient = new MockClient();
        $response   = new Response(
            201,
            ['Content-Type' => 'application/json'],
            \file_get_contents(__DIR__ . '/Fixtures/posted_audio_playlist_component.json')
        );
        $httpClient->addResponse($response);

        $winguApi = new AudioPlaylistApi($configurationMock, $httpClient, $requestFactory, $hydrator);

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
        $requestFactory    = new GuzzleMessageFactory();
        $hydrator          = new SymfonySerializerHydrator();

        $httpClient = new MockClient();
        $response   = new Response(
            204,
            ['Content-Type' => 'application/json']
        );
        $httpClient->addResponse($response);

        $winguApi = new AudioPlaylistApi($configurationMock, $httpClient, $requestFactory, $hydrator);

        $winguApi->update(
            'b75ea792-07fe-427f-a1b5-867e25a29c23',
            new Update(
                'updated playlist name'
            )
        );

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();
        self::assertSame('{"name":"updated playlist name"}', $actualRequest->getBody()->getContents());
        self::assertSame('PATCH', $actualRequest->getMethod());
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
}
