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
use Wingu\Engine\SDK\Model\Request\Component\ImageGallery\Image\Create as CreateImage;
use Wingu\Engine\SDK\Model\Request\Component\ImageGallery\Image\Update as UpdateImage;
use Wingu\Engine\SDK\Model\Request\Component\ImageGallery\ImagesPosition;
use Wingu\Engine\SDK\Model\Response\Component\Image;
use Wingu\Engine\SDK\Model\Response\Component\ImageGallery;
use Wingu\Engine\SDK\Model\Response\Component\ImageGalleryImage;
use Wingu\Engine\SDK\Model\Response\Component\ImageMetadata;
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

    public function testCreateImageReturnsNewImageGalleryImage() : void
    {
        $configurationMock = new Configuration();
        $requestFactory    = new GuzzleMessageFactory();
        $hydrator          = new SymfonySerializerHydrator();

        $httpClient = new MockClient();
        $response   = new Response(
            201,
            ['Content-Type' => 'application/json'],
            $this->getDataFromFixturesFile('posted_image_gallery_image.json')
        );
        $httpClient->addResponse($response);

        $winguApi = new ImageGalleryApi($configurationMock, $httpClient, $requestFactory, $hydrator);

        $actualResponse = $winguApi->createImage(
            '75989153-1f69-49e2-82e7-d8892e6ddfab',
            new CreateImage(\GuzzleHttp\Psr7\stream_for(\fopen('examples/wingu_image.png', 'rb')), 'wingu icon')
        );

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();

        self::assertStringStartsWith('multipart/form-data; boundary="', $actualRequest->getHeaderLine('Content-Type'));
        $actualRequestBody = $actualRequest->getBody()->getContents();
        self::assertContains('Content-Disposition: form-data; name="caption"', $actualRequestBody);
        self::assertContains(
            'Content-Disposition: form-data; name="image"; filename="wingu_image.png"',
            $actualRequestBody
        );
        self::assertSame('POST', $actualRequest->getMethod());

        $expectedResponse = $this->getExpectedImageGalleryImage();
        self::assertEquals($expectedResponse, $actualResponse);
    }

    public function testUpdateImagePatchesImageGalleryImage() : void
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

        $winguApi = new ImageGalleryApi($configurationMock, $httpClient, $requestFactory, $hydrator);

        $winguApi->updateImage(
            '95d6a519-7824-4fba-86d1-60f70ef6ace1',
            new UpdateImage(
                1,
                'updated image name'
            )
        );

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();
        self::assertSame('{"positionSort":1,"caption":"updated image name"}', $actualRequest->getBody()->getContents());
        self::assertSame('PATCH', $actualRequest->getMethod());
    }

    public function testUpdateImagesPositionPatchesImageGalleryImagesPosition() : void
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

        $winguApi = new ImageGalleryApi($configurationMock, $httpClient, $requestFactory, $hydrator);

        $winguApi->updateImagesPosition(
            '95d6a519-7824-4fba-86d1-60f70ef6ace1',
            new ImagesPosition([
                'e5b3f59b-ab83-4e97-8618-17792d48df42',
                'fb819ced-fb94-4ef2-9982-f12ee8fc4203',
            ])
        );

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();
        self::assertSame(
            '{"orderedImages":["e5b3f59b-ab83-4e97-8618-17792d48df42","fb819ced-fb94-4ef2-9982-f12ee8fc4203"]}',
            $actualRequest->getBody()->getContents()
        );
        self::assertSame('PUT', $actualRequest->getMethod());
    }

    public function testDeleteImageRemovesImageGalleryImage() : void
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

        $winguApi = new ImageGalleryApi($configurationMock, $httpClient, $requestFactory, $hydrator);

        $winguApi->deleteImage('95d6a519-7824-4fba-86d1-60f70ef6ace1');

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();
        self::assertSame('', $actualRequest->getBody()->getContents());
        self::assertSame('DELETE', $actualRequest->getMethod());
    }


    private function getExpectedImageGallery() : ImageGallery
    {
        return new ImageGallery(
            '84dea838-ba2e-416c-b344-7af0e4517b92',
            new \DateTime('2018-09-07T11:30:53+0000'),
            []
        );
    }

    private function getExpectedImageGalleryImage() : ImageGalleryImage
    {
        return new ImageGalleryImage(
            '95d6a519-7824-4fba-86d1-60f70ef6ace1',
            0,
            new Image(
                new ImageMetadata('jpg', 400, 400),
                'dev-components-imagegallery-68e5d517d241611a2278c9f1355b7691',
                'cloudinary'
            ),
            'wingu icon'
        );
    }
}
