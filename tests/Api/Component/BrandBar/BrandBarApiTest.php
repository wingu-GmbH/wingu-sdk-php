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
use Wingu\Engine\SDK\Model\Request\Component\BrandBar\Image\Update as UpdateImage;
use Wingu\Engine\SDK\Model\Request\Component\BrandBar\Text\Create as CreateText;
use Wingu\Engine\SDK\Model\Request\Component\BrandBar\Text\Update as UpdateText;
use Wingu\Engine\SDK\Model\Request\Component\BrandBar\Update;
use Wingu\Engine\SDK\Model\Response\Component\BrandBar;
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
            \file_get_contents(__DIR__ . '/Fixtures/posted_brand_bar_component.json')
        );
        $httpClient->addResponse($response);

        $winguApi = new BrandBarApi($configurationMock, $httpClient, $requestFactory, $hydrator);

        $actualResponse = $winguApi->create(
            new Create(
                new CreateText('brandbar text', 'left', '04b1f0'),
                new CreateImage('left'),
                '2b7d83'
            )
        );

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();
        self::assertSame('{"text":{"text":"brandbar text","alignment":"left","color":"04b1f0"},"image":{"alignment":"left"},"backgroundColor":"2b7d83"}', $actualRequest->getBody()->getContents());
        self::assertSame('POST', $actualRequest->getMethod());

        $expectedResponse = $this->getExpectedBrandBar();
        self::assertEquals($expectedResponse, $actualResponse);
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
            new Update(
                new UpdateText('edited text', 'center', '2b7d83'),
                new UpdateImage('right'),
                '04b1f0'
            )
        );

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();
        self::assertSame('{"text":{"text":"edited text","alignment":"center","color":"2b7d83"},"image":{"alignment":"right"},"backgroundColor":"04b1f0"}', $actualRequest->getBody()->getContents());
        self::assertSame('PATCH', $actualRequest->getMethod());
    }

    private function getExpectedBrandBar() : BrandBar
    {
        return new BrandBar(
            'a65747f7-7093-4bf5-ab2f-5fd0d5699ab5',
            new \DateTime('2018-09-07T09:09:30+0000')
        );
    }
}
