<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Tests\Api\Component\CMS;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Wingu\Engine\SDK\Api\Component\CMSApi;
use Wingu\Engine\SDK\Api\Configuration;
use Wingu\Engine\SDK\Model\Request\Component\CMS\Create as CreateCMS;
use Wingu\Engine\SDK\Model\Request\Component\CMS\Update as UpdateCMS;
use Wingu\Engine\SDK\Model\Response\Component\CMS;
use Wingu\Engine\SDK\Tests\Api\ApiTest;

class CMSApiTest extends ApiTest
{
    public function testCreateReturnsNewCmsComponent() : void
    {
        $configurationMock = new Configuration();

        $httpClient = self::createClient();
        $response   = new Response(
            201,
            ['Content-Type' => 'application/json'],
            $this->getDataFromFixturesFile('posted_cms_component.json')
        );
        $httpClient->addResponse($response);

        $winguApi = new CMSApi($configurationMock, $httpClient);

        $actualResponse = $winguApi->create(
            new CreateCMS(
                'just test',
                'html'
            )
        );

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();
        self::assertSame('{"content":"just test","type":"html"}', $actualRequest->getBody()->getContents());
        self::assertSame('POST', $actualRequest->getMethod());

        $expectedResponse = $this->getExpectedCms();
        self::assertEquals($expectedResponse, $actualResponse);
    }

    public function testUpdatePatchesCmsComponent() : void
    {
        $configurationMock = new Configuration();

        $httpClient = self::createClient();
        $response   = new Response(
            204,
            ['Content-Type' => 'application/json']
        );
        $httpClient->addResponse($response);

        $winguApi = new CMSApi($configurationMock, $httpClient);

        $winguApi->update(
            '261a7aab-4b03-4817-b471-060c2e046826',
            new UpdateCMS(
                'update',
                'html'
            )
        );

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();
        self::assertSame('{"content":"update","type":"html"}', $actualRequest->getBody()->getContents());
        self::assertSame('PATCH', $actualRequest->getMethod());
    }

    private function getExpectedCms() : CMS
    {
        return new CMS(
            '261a7aab-4b03-4817-b471-060c2e046826',
            new \DateTime('2018-06-05T13:08:11+0000'),
            'just test',
            'html'
        );
    }
}
