<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Tests\Api\Component\BrandBar;

use GuzzleHttp\Psr7\Response;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use Http\Mock\Client as MockClient;
use Psr\Http\Message\RequestInterface;
use Wingu\Engine\SDK\Api\Component\BrandBarApi;
use Wingu\Engine\SDK\Api\Configuration;
use Wingu\Engine\SDK\Hydrator\SymfonySerializerHydrator;
use Wingu\Engine\SDK\Model\Request\Component\BrandBar\Create;
use Wingu\Engine\SDK\Model\Request\Component\BrandBar\Image\Create as CreateImage;
use Wingu\Engine\SDK\Model\Request\Component\BrandBar\Text\Create as CreateText;
use Wingu\Engine\SDK\Model\Request\Component\BrandBar\Update;
use Wingu\Engine\SDK\Model\Response\Component\BrandBar;
use Wingu\Engine\SDK\Model\Response\Component\BrandBarBackground;
use Wingu\Engine\SDK\Model\Response\Component\BrandBarImage;
use Wingu\Engine\SDK\Model\Response\Component\BrandBarText;
use Wingu\Engine\SDK\Model\Response\Component\Image;
use Wingu\Engine\SDK\Model\Response\Component\ImageMetadata;
use Wingu\Engine\SDK\Tests\Api\ApiTest;

class BrandBarApiTest extends ApiTest
{
    public function testCreateReturnsNewBrandBarComponent() : void
    {
        $configurationMock = new Configuration();
        $requestFactory    = new GuzzleMessageFactory();
        $hydrator          = new SymfonySerializerHydrator();

        $httpClient = new MockClient();
        $response   = new Response(
            201,
            ['Content-Type' => 'application/json'],
            $this->getDataFromFixturesFile('posted_brand_bar_component.json')
        );
        $httpClient->addResponse($response);

        $winguApi = new BrandBarApi($configurationMock, $httpClient, $requestFactory, $hydrator);

        $actualResponse = $winguApi->create(
            new Create(
                new CreateText('brandbar text', 'left', '04b1f0'),
                new CreateImage(
                    'left',
                    \GuzzleHttp\Psr7\stream_for(\fopen('examples/wingu_image.png', 'rb'))
                ),
                '2b7d83'
            )
        );

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();

        self::assertStringStartsWith('multipart/form-data; boundary="', $actualRequest->getHeaderLine('Content-Type'));
        $actualRequestBody = $actualRequest->getBody()->getContents();
        self::assertContains('Content-Disposition: form-data; name="text[alignment]"', $actualRequestBody);
        self::assertContains('Content-Disposition: form-data; name="text[color]"', $actualRequestBody);
        self::assertContains('Content-Disposition: form-data; name="image[alignment]"', $actualRequestBody);
        self::assertContains('Content-Disposition: form-data; name="backgroundColor"', $actualRequestBody);
        self::assertContains(
            'Content-Disposition: form-data; name="image"; filename="wingu_image.png"',
            $actualRequestBody
        );
        self::assertSame('POST', $actualRequest->getMethod());

        $expectedResponse = $this->getExpectedBrandBar();
        self::assertEquals($expectedResponse, $actualResponse);
    }

    public function testCreateThrowsExceptionWhenTextAndImageAreBothNull() : void
    {
        $configurationMock = new Configuration();
        $requestFactory    = new GuzzleMessageFactory();
        $hydrator          = new SymfonySerializerHydrator();

        $httpClient = new MockClient();
        $response   = new Response(
            500,
            ['Content-Type' => 'application/json']
        );
        $httpClient->addResponse($response);

        $winguApi = new BrandBarApi($configurationMock, $httpClient, $requestFactory, $hydrator);

        $this->expectException(\Throwable::class);
        $this->expectExceptionMessage('BrandBar requires either Text or Image, or both');

        $winguApi->create(
            new Create(null, null, '04b1f0')
        );
    }

    public function testUpdatePatchesBrandBarComponent() : void
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

        $winguApi = new BrandBarApi($configurationMock, $httpClient, $requestFactory, $hydrator);

        $winguApi->update(
            'a65747f7-7093-4bf5-ab2f-5fd0d5699ab5',
            new Update(null, null, null)
        );

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();
        self::assertSame('{"text":null,"image":null,"backgroundColor":null}', $actualRequest->getBody()->getContents());
        self::assertSame('PATCH', $actualRequest->getMethod());
    }

    private function getExpectedBrandBar() : BrandBar
    {
        return new BrandBar(
            'a65747f7-7093-4bf5-ab2f-5fd0d5699ab5',
            new \DateTime('2018-09-07T09:09:30+0000'),
            new BrandBarBackground('2b7d83'),
            new BrandBarText('brandbar text', 'left', '04b1f0'),
            new BrandBarImage(new Image(new ImageMetadata('png', 30, 30), 'sample', 'cloudinary'), 'left')
        );
    }
}
