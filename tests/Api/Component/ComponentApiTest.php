<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Tests\Api\Component;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Wingu\Engine\SDK\Api\Component\ComponentApi;
use Wingu\Engine\SDK\Api\Configuration;
use Wingu\Engine\SDK\Model\Request\Component\Copy;
use Wingu\Engine\SDK\Tests\Api\ApiTest;
use Wingu\Engine\SDK\Tests\Api\Expected\Loader\PrivateComponent;

final class ComponentApiTest extends ApiTest
{
    use PrivateComponent;

    public function testMyComponentReturnsComponent() : void
    {
        $configurationMock = new Configuration();

        $httpClient = self::createClient();
        $httpClient->addResponse(
            new Response(
                200,
                ['Content-Type' => 'application/json'],
                $this->getDataFromFixturesFile('full_component.json')
            )
        );

        $winguApi = new ComponentApi($configurationMock, $httpClient);

        $actual   = $winguApi->myComponent('a81700f1-83d1-4d1c-be86-37410b6a8d0a');
        $expected = $this->getExpectedFilesComponent();

        self::assertEquals($expected, $actual);
    }

    public function testMyComponentsReturnsResult() : void
    {
        $configurationMock = new Configuration();

        $httpClient = self::createClient();
        $httpClient->addResponse(
            new Response(
                200,
                ['Content-Type' => 'application/json'],
                $this->getDataFromFixturesFile('full_components.json')
            )
        );

        $componentApi = new ComponentApi($configurationMock, $httpClient);
        $actual       = $componentApi->myComponents();

        $expected = [
            $this->getExpectedActionComponent(),
            $this->getExpectedAudioPlaylistComponent(),
            $this->getExpectedBrandBarComponent(),
            $this->getExpectedHtmlComponent(),
            $this->getExpectedContactComponent(),
            $this->getExpectedCouponComponent(),
            $this->getExpectedFilesComponent(),
            $this->getExpectedFormComponent(),
            $this->getExpectedImageGalleryComponent(),
            $this->getExpectedLocationComponent(),
            $this->getExpectedRatingComponent(),
            $this->getExpectedSeparatorComponent(),
            $this->getExpectedSurveyMonkeyComponent(),
            $this->getExpectedVideoComponent(),
            $this->getExpectedWebhookComponent(),
        ];

        self::assertCount(\count($expected), $actual);
        self::assertEquals($expected, \iterator_to_array($actual));
    }

    public function testCopyComponentCopiesComponentToMultipleDecks() : void
    {
        $configurationMock = new Configuration();

        $httpClient = self::createClient();
        $response   = new Response(
            204,
            ['Content-Type' => 'application/json']
        );
        $httpClient->addResponse($response);

        $winguApi = new ComponentApi($configurationMock, $httpClient);

        $winguApi->copyMyComponent(
            '666dd3d7-5568-4b01-ae80-22899ca5fec5',
            new Copy(
                [
                    'ea45b0c8-0000-4000-a000-000000000017',
                    'ea45b0c8-0000-4000-a000-000000000018',
                    'ea45b0c8-0000-4000-a000-000000000019',
                ]
            )
        );

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();
        $contents      = $actualRequest->getBody()->getContents();
        self::assertSame(
            '{"decks":["ea45b0c8-0000-4000-a000-000000000017","ea45b0c8-0000-4000-a000-000000000018","ea45b0c8-0000-4000-a000-000000000019"]}',
            $contents
        );
        self::assertSame('PUT', $actualRequest->getMethod());
    }
}
