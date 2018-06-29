<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Tests\Api\Content;

use GuzzleHttp\Psr7\Response;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use Http\Mock\Client as MockClient;
use Wingu\Engine\SDK\Api\Configuration;
use Wingu\Engine\SDK\Api\Content\ContentTemplate;
use Wingu\Engine\SDK\Hydrator\SymfonySerializerHydrator;
use Wingu\Engine\SDK\Model\Response\Content\Template;
use Wingu\Engine\SDK\Tests\Api\ApiTest;

final class ContentTemplateTest extends ApiTest
{
    public function testTemplatesReturnsTemplates() : void
    {
        $configurationMock = new Configuration();
        $requestFactory    = new GuzzleMessageFactory();
        $hydrator          = new SymfonySerializerHydrator();

        $httpClient = new MockClient();
        $httpClient->addResponse(
            new Response(
                200,
                ['Content-Type' => 'application/json'],
                \file_get_contents(__DIR__ . '/Fixtures/content_templates_list.json')
            )
        );

        $winguApi = new ContentTemplate($configurationMock, $httpClient, $requestFactory, $hydrator);
        $actual   = $winguApi->templates();

        $expected = [
            $this->getExpectedTemplate(),
        ];

        self::assertCount(1, $actual);
        self::assertEquals($expected, \iterator_to_array($actual));
    }

    private function getExpectedTemplate() : Template
    {
        return new Template(
            '00da2678-7517-4751-996c-ec21edb662ed',
            '#FFFFFF',
            '#000000',
            'sans-serif'
        );
    }
}
