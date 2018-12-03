<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Tests\Api\Component\Webhook;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Wingu\Engine\SDK\Api\Component\WebhookApi;
use Wingu\Engine\SDK\Api\Configuration;
use Wingu\Engine\SDK\Model\Request\Component\Webhook\Create;
use Wingu\Engine\SDK\Model\Request\Component\Webhook\Update;
use Wingu\Engine\SDK\Model\Response\Component\PrivateWebhook;
use Wingu\Engine\SDK\Model\Response\Component\Trigger;
use Wingu\Engine\SDK\Model\Response\Component\WebhookTrigger;
use Wingu\Engine\SDK\Tests\Api\ApiTest;

class WebhookApiTest extends ApiTest
{
    public function testCreateReturnsNewWebhookComponent() : void
    {
        $configurationMock = new Configuration();

        $httpClient = self::createClient();
        $response   = new Response(
            201,
            ['Content-Type' => 'application/json'],
            $this->getDataFromFixturesFile('posted_webhook_component.json')
        );
        $httpClient->addResponse($response);

        $winguApi = new WebhookApi($configurationMock, $httpClient);

        $actualResponse = $winguApi->create(
            new Create(
                'Trigger me',
                'Success message!',
                'https://httpbin.org/status/200'
            )
        );

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();
        self::assertSame(
            '{"buttonCaption":"Trigger me","feedbackSuccessMessage":"Success message!","url":"https:\/\/httpbin.org\/status\/200"}',
            $actualRequest->getBody()->getContents()
        );
        self::assertSame('POST', $actualRequest->getMethod());

        $expectedResponse = $this->getExpectedWebhook();
        self::assertEquals($expectedResponse, $actualResponse);
    }

    public function testUpdatePatchesWebhookComponent() : void
    {
        $configurationMock = new Configuration();

        $httpClient = self::createClient();
        $response   = new Response(
            204,
            ['Content-Type' => 'application/json']
        );
        $httpClient->addResponse($response);

        $winguApi = new WebhookApi($configurationMock, $httpClient);

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
        self::assertSame(
            '{"buttonCaption":"Triggered","feedbackSuccessMessage":"html","url":"https:\/\/httpbin.org\/status\/200"}',
            $actualRequest->getBody()->getContents()
        );
        self::assertSame('PATCH', $actualRequest->getMethod());
    }

    public function testTriggerWebhookTriggersWebhook() : void
    {
        $configurationMock = new Configuration();

        $httpClient = self::createClient();
        $httpClient->addResponse(
            new Response(
                200,
                ['Content-Type' => 'application/json'],
                $this->getDataFromFixturesFile('trigger_webhook_response.json')
            )
        );

        $contentApi = new WebhookApi($configurationMock, $httpClient);
        $actual     = $contentApi->trigger('1f8da2a7-984e-4ba3-a80c-2bb278f6a0a8');

        $expected = $this->getExpectedWebhookTriggerResponse();
        self::assertEquals($expected, $actual);
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

    private function getExpectedWebhookTriggerResponse() : WebhookTrigger
    {
        return new WebhookTrigger(
            new Trigger(true),
            'Triggered successfully!'
        );
    }
}
