<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Tests\Api\Component\Files;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Wingu\Engine\SDK\Api\Component\FilesApi;
use Wingu\Engine\SDK\Api\Configuration;
use Wingu\Engine\SDK\Model\Request\Component\Files\Create;
use Wingu\Engine\SDK\Model\Request\Component\Files\File\Create as CreateFile;
use Wingu\Engine\SDK\Model\Request\Component\Files\File\Update as UpdateFile;
use Wingu\Engine\SDK\Model\Response\Component\Files;
use Wingu\Engine\SDK\Model\Response\Component\FilesFile;
use Wingu\Engine\SDK\Tests\Api\ApiTest;

class FilesApiTest extends ApiTest
{
    public function testCreateReturnsNewFilesComponent() : void
    {
        $configurationMock = new Configuration();

        $httpClient = self::createClient();
        $response   = new Response(
            201,
            ['Content-Type' => 'application/json'],
            $this->getDataFromFixturesFile('posted_files_component.json')
        );
        $httpClient->addResponse($response);

        $winguApi = new FilesApi($configurationMock, $httpClient);

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

    public function testCreateFileReturnsNewFilesFile() : void
    {
        $configurationMock = new Configuration();

        $httpClient = self::createClient();
        $response   = new Response(
            201,
            ['Content-Type' => 'application/json'],
            $this->getDataFromFixturesFile('posted_files_file.json')
        );
        $httpClient->addResponse($response);

        $winguApi = new FilesApi($configurationMock, $httpClient);

        $actualResponse = $winguApi->createFile(
            '55d9a8ec-87dc-41c9-a4fe-1b8d5603e004',
            new CreateFile(
                \GuzzleHttp\Psr7\stream_for(\fopen('examples/wingu_presentation.pdf', 'rb')),
                'file name'
            )
        );

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();

        self::assertStringStartsWith('multipart/form-data; boundary="', $actualRequest->getHeaderLine('Content-Type'));
        $actualRequestBody = $actualRequest->getBody()->getContents();
        self::assertContains('Content-Disposition: form-data; name="name"', $actualRequestBody);
        self::assertContains(
            'Content-Disposition: form-data; name="file"; filename="wingu_presentation.pdf"',
            $actualRequestBody
        );
        self::assertSame('POST', $actualRequest->getMethod());

        $expectedResponse = $this->getExpectedFilesFile();
        self::assertEquals($expectedResponse, $actualResponse);
    }

    public function testUpdateFilePatchesFilesFile() : void
    {
        $configurationMock = new Configuration();

        $httpClient = self::createClient();
        $response   = new Response(
            204,
            ['Content-Type' => 'application/json']
        );
        $httpClient->addResponse($response);

        $winguApi = new FilesApi($configurationMock, $httpClient);

        $winguApi->updateFile(
            'd7709b2e-5c62-4c01-85ed-0885dffa294b',
            new UpdateFile(
                'update filename'
            )
        );

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();
        self::assertSame('{"name":"update filename"}', $actualRequest->getBody()->getContents());
        self::assertSame('PATCH', $actualRequest->getMethod());
    }

    private function getExpectedFiles() : Files
    {
        return new Files(
            'fce03a7d-2bd9-48e8-a23c-d5503c6f1303',
            new \DateTime('2018-09-07T11:21:57+0000'),
            []
        );
    }

    private function getExpectedFilesFile() : FilesFile
    {
        return new FilesFile(
            'd7709b2e-5c62-4c01-85ed-0885dffa294b',
            0,
            'http://example.com/wingu-dev-components/files/b9d69874c9f3fad01c47866febb028ea134bce68050cb6e05b79dd743f57d708.pdf',
            'test file',
            249016
        );
    }
}
