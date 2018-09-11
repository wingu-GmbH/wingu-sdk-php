<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Tests\Api\Component\Webhook;

use GuzzleHttp\Psr7\Response;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use Http\Mock\Client as MockClient;
use Psr\Http\Message\RequestInterface;
use Wingu\Engine\SDK\Api\Component\WebhookApi;
use Wingu\Engine\SDK\Api\Configuration;
use Wingu\Engine\SDK\Hydrator\SymfonySerializerHydrator;
use Wingu\Engine\SDK\Model\Request\Component\Webhook\Create;
use Wingu\Engine\SDK\Model\Request\Component\Webhook\Update;
use Wingu\Engine\SDK\Model\Response\Component\PrivateWebhook;
use Wingu\Engine\SDK\Tests\Api\ApiTest;

class WebhookApiTest extends ApiTest
{
    public function testCreateReturnsNewWebhookComponent() : void
    {
        $configurationMock = new Configuration();
        $requestFactory    = new GuzzleMessageFactory();
        $hydrator          = new SymfonySerializerHydrator();

        $httpClient = new MockClient();
        $response   = new Response(
            201,
            ['Content-Type' => 'application/json'],
            $this->getDataFromFixturesFile('posted_webhook_component.json')
        );
        $httpClient->addResponse($response);

        $winguApi = new WebhookApi($configurationMock, $httpClient, $requestFactory, $hydrator);

        $actualResponse = $winguApi->create(
            new Create(
                'Trigger me',
                'Success message!',
                'https://httpbin.org/status/200'
            )
        );

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();
        self::assertSame('{"buttonCaption":"Trigger me","feedbackSuccessMessage":"Success message!","url":"https:\/\/httpbin.org\/status\/200"}', $actualRequest->getBody()->getContents());
        self::assertSame('POST', $actualRequest->getMethod());

        $expectedResponse = $this->getExpectedWebhook();
        self::assertEquals($expectedResponse, $actualResponse);
    }

    public function testUpdatePatchesWebhookComponent() : void
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

        $winguApi = new WebhookApi($configurationMock, $httpClient, $requestFactory, $hydrator);

        $winguApi->update(
            '0104987b-390f-4f1f-9554-a148df61b90f',
            new Update(
                'Triggered',
                'html',
                'https://httpbin.org/status/200'
            )
        );

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();
        self::assertSame('{"buttonCaption":"Triggered","feedbackSuccessMessage":"html","url":"https:\/\/httpbin.org\/status\/200"}', $actualRequest->getBody()->getContents());
        self::assertSame('PATCH', $actualRequest->getMethod());
    }

    private function getExpectedWebhook() : PrivateWebhook
    {
        return new PrivateWebhook(
            '0104987b-390f-4f1f-9554-a148df61b90f',
            new \DateTime('2018-09-07T12:00:00+0000'),
            'Trigger me',
            'https://httpbin.org/status/200',
            'Success message!'
        );
    }
}
