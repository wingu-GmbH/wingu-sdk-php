<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Tests\Api\Component\ImageGallery;

use GuzzleHttp\Psr7\Response;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use Http\Mock\Client as MockClient;
use Psr\Http\Message\RequestInterface;
use Wingu\Engine\SDK\Api\Component\ImageGalleryApi;
use Wingu\Engine\SDK\Api\Configuration;
use Wingu\Engine\SDK\Hydrator\SymfonySerializerHydrator;
use Wingu\Engine\SDK\Model\Request\Component\ImageGallery\Create;
use Wingu\Engine\SDK\Model\Response\Component\ImageGallery;
use Wingu\Engine\SDK\Tests\Api\ApiTest;

class ImageGalleryApiTest extends ApiTest
{
    public function testCreateReturnsNewImageGalleryComponent() : void
    {
        $configurationMock = new Configuration();
        $requestFactory    = new GuzzleMessageFactory();
        $hydrator          = new SymfonySerializerHydrator();

        $httpClient = new MockClient();
        $response   = new Response(
            201,
            ['Content-Type' => 'application/json'],
            $this->getDataFromFixturesFile('posted_image_gallery_component.json')
        );
        $httpClient->addResponse($response);

        $winguApi = new ImageGalleryApi($configurationMock, $httpClient, $requestFactory, $hydrator);

        $actualResponse = $winguApi->create(
            new Create()
        );

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();
        self::assertSame('[]', $actualRequest->getBody()->getContents());
        self::assertSame('POST', $actualRequest->getMethod());

        $expectedResponse = $this->getExpectedImageGallery();
        self::assertEquals($expectedResponse, $actualResponse);
    }

    private function getExpectedImageGallery() : ImageGallery
    {
        return new ImageGallery(
            '84dea838-ba2e-416c-b344-7af0e4517b92',
            new \DateTime('2018-09-07T11:30:53+0000'),
            []
        );
    }
}
