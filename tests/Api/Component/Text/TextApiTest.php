<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Tests\Api\Component\Text;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Wingu\Engine\SDK\Api\Component\TextApi;
use Wingu\Engine\SDK\Api\Configuration;
use Wingu\Engine\SDK\Model\Request\Component\Text\Create as CreateText;
use Wingu\Engine\SDK\Model\Request\Component\Text\Update as UpdateText;
use Wingu\Engine\SDK\Model\Response\Component\Text;
use Wingu\Engine\SDK\Tests\Api\ApiTest;

class TextApiTest extends ApiTest
{
    public function testCreateReturnsNewTextComponent() : void
    {
        $configurationMock = new Configuration();

        $httpClient = self::createClient();
        $response   = new Response(
            201,
            ['Content-Type' => 'application/json'],
            $this->getDataFromFixturesFile('posted_text_component.json')
        );
        $httpClient->addResponse($response);

        $winguApi = new TextApi($configurationMock, $httpClient);

        $actualResponse = $winguApi->create(
            new CreateText(
                'just test',
                'markdown'
            )
        );

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();
        self::assertSame('{"content":"just test","type":"markdown"}', $actualRequest->getBody()->getContents());
        self::assertSame('POST', $actualRequest->getMethod());

        $expectedResponse = $this->getExpectedText();
        self::assertEquals($expectedResponse, $actualResponse);
    }

    public function testUpdatePatchesTextComponent() : void
    {
        $configurationMock = new Configuration();

        $httpClient = self::createClient();
        $response   = new Response(
            204,
            ['Content-Type' => 'application/json']
        );
        $httpClient->addResponse($response);

        $winguApi = new TextApi($configurationMock, $httpClient);

        $winguApi->update(
            '261a7aab-4b03-4817-b471-060c2e046826',
            new UpdateText(
                'update',
                'markdown'
            )
        );

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();
        self::assertSame('{"content":"update","type":"markdown"}', $actualRequest->getBody()->getContents());
        self::assertSame('PATCH', $actualRequest->getMethod());
    }

    private function getExpectedText() : Text
    {
        return new Text(
            '261a7aab-4b03-4817-b471-060c2e046826',
            new \DateTime('2018-06-05T13:08:11+0000'),
            'just test',
            'markdown'
        );
    }
}
