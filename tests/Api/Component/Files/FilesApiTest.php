<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Tests\Api\Component\Files;

use GuzzleHttp\Psr7\Response;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use Http\Mock\Client as MockClient;
use Psr\Http\Message\RequestInterface;
use Wingu\Engine\SDK\Api\Component\FilesApi;
use Wingu\Engine\SDK\Api\Configuration;
use Wingu\Engine\SDK\Hydrator\SymfonySerializerHydrator;
use Wingu\Engine\SDK\Model\Request\Component\Files\Create;
use Wingu\Engine\SDK\Model\Response\Component\Files;
use Wingu\Engine\SDK\Tests\Api\ApiTest;

class FilesApiTest extends ApiTest
{
    public function testCreateReturnsNewFilesComponent() : void
    {
        $configurationMock = new Configuration();
        $requestFactory    = new GuzzleMessageFactory();
        $hydrator          = new SymfonySerializerHydrator();

        $httpClient = new MockClient();
        $response   = new Response(
            201,
            ['Content-Type' => 'application/json'],
            $this->getDataFromFixturesFile('posted_files_component.json')
        );
        $httpClient->addResponse($response);

        $winguApi = new FilesApi($configurationMock, $httpClient, $requestFactory, $hydrator);

        $actualResponse = $winguApi->create(
            new Create()
        );

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();
        self::assertSame('[]', $actualRequest->getBody()->getContents());
        self::assertSame('POST', $actualRequest->getMethod());

        $expectedResponse = $this->getExpectedFiles();
        self::assertEquals($expectedResponse, $actualResponse);
    }

    private function getExpectedFiles() : Files
    {
        return new Files(
            'fce03a7d-2bd9-48e8-a23c-d5503c6f1303',
            new \DateTime('2018-09-07T11:21:57+0000'),
            []
        );
    }
}
