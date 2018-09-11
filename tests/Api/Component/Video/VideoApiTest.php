<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Tests\Api\Component\Video;

use GuzzleHttp\Psr7\Response;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use Http\Mock\Client as MockClient;
use Psr\Http\Message\RequestInterface;
use Wingu\Engine\SDK\Api\Component\VideoApi;
use Wingu\Engine\SDK\Api\Configuration;
use Wingu\Engine\SDK\Hydrator\SymfonySerializerHydrator;
use Wingu\Engine\SDK\Model\Request\Component\Video\Create;
use Wingu\Engine\SDK\Model\Request\Component\Video\Update;
use Wingu\Engine\SDK\Model\Response\Component\Video;
use Wingu\Engine\SDK\Tests\Api\ApiTest;

class VideoApiTest extends ApiTest
{
    public function testCreateReturnsNewVideoComponent() : void
    {
        $configurationMock = new Configuration();
        $requestFactory    = new GuzzleMessageFactory();
        $hydrator          = new SymfonySerializerHydrator();

        $httpClient = new MockClient();
        $response   = new Response(
            201,
            ['Content-Type' => 'application/json'],
            \file_get_contents(__DIR__ . '/Fixtures/posted_video_component.json')
        );
        $httpClient->addResponse($response);

        $winguApi = new VideoApi($configurationMock, $httpClient, $requestFactory, $hydrator);

        $actualResponse = $winguApi->create(
            new Create(
                'youtube',
                'zfQdPcO--DA',
                'Video description'
            )
        );

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();
        self::assertSame('{"type":"youtube","payload":"zfQdPcO--DA","description":"Video description"}', $actualRequest->getBody()->getContents());
        self::assertSame('POST', $actualRequest->getMethod());

        $expectedResponse = $this->getExpectedVideo();
        self::assertEquals($expectedResponse, $actualResponse);
    }

    public function testUpdatePatchesVideoComponent() : void
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

        $winguApi = new VideoApi($configurationMock, $httpClient, $requestFactory, $hydrator);

        $winguApi->update(
            '800ff36f-e13b-4711-a413-d6b412875f16',
            new Update(
                'youtube',
                'zfQdPcO--DA',
                'Video description that has been edited'
            )
        );

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();
        self::assertSame('{"type":"youtube","payload":"zfQdPcO--DA","description":"Video description that has been edited"}', $actualRequest->getBody()->getContents());
        self::assertSame('PATCH', $actualRequest->getMethod());
    }

    private function getExpectedVideo() : Video
    {
        return new Video(
            '800ff36f-e13b-4711-a413-d6b412875f16',
            new \DateTime('2018-09-07T11:56:19+0000'),
            'youtube',
            'zfQdPcO--DA',
            'Video description'
        );
    }
}
