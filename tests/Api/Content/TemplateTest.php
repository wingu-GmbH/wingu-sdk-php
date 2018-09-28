<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Tests\Api\Content;

use GuzzleHttp\Psr7\Response;
use Http\Mock\Client as MockClient;
use Wingu\Engine\SDK\Api\Configuration;
use Wingu\Engine\SDK\Api\Content\Template;
use Wingu\Engine\SDK\Model\Response\Content\Template as TemplateModel;
use Wingu\Engine\SDK\Tests\Api\ApiTest;

final class TemplateTest extends ApiTest
{
    public function testTemplatesReturnsTemplates() : void
    {
        $configurationMock = new Configuration();

        $httpClient = new MockClient();
        $httpClient->addResponse(
            new Response(
                200,
                ['Content-Type' => 'application/json'],
                $this->getDataFromFixturesFile('content_templates_list.json')
            )
        );

        $winguApi = new Template($configurationMock, $httpClient);
        $actual   = $winguApi->templates();

        $expected = [
            $this->getExpectedTemplate(),
        ];

        self::assertCount(1, $actual);
        self::assertEquals($expected, \iterator_to_array($actual));
    }

    private function getExpectedTemplate() : TemplateModel
    {
        return new TemplateModel(
            '00da2678-7517-4751-996c-ec21edb662ed',
            '#FFFFFF',
            '#000000',
            'sans-serif'
        );
    }
}
