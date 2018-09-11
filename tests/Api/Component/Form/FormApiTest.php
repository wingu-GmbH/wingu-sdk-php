<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Tests\Api\Component\Form;

use GuzzleHttp\Psr7\Response;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use Http\Mock\Client as MockClient;
use Psr\Http\Message\RequestInterface;
use Wingu\Engine\SDK\Api\Component\FormApi;
use Wingu\Engine\SDK\Api\Configuration;
use Wingu\Engine\SDK\Hydrator\SymfonySerializerHydrator;
use Wingu\Engine\SDK\Model\Request\BooleanValue;
use Wingu\Engine\SDK\Model\Request\Component\Form\Create;
use Wingu\Engine\SDK\Model\Request\Component\Form\Resubmit\Create as CreateResubmit;
use Wingu\Engine\SDK\Model\Request\Component\Form\Resubmit\Update as UpdateResubmit;
use Wingu\Engine\SDK\Model\Request\Component\Form\Update;
use Wingu\Engine\SDK\Model\Response\Component\PrivateForm;
use Wingu\Engine\SDK\Tests\Api\ApiTest;

class FormApiTest extends ApiTest
{
    public function testCreateReturnsNewFormComponent() : void
    {
        $configurationMock = new Configuration();
        $requestFactory    = new GuzzleMessageFactory();
        $hydrator          = new SymfonySerializerHydrator();

        $httpClient = new MockClient();
        $response   = new Response(
            201,
            ['Content-Type' => 'application/json'],
            $this->getDataFromFixturesFile('posted_form_component.json')
        );
        $httpClient->addResponse($response);

        $winguApi = new FormApi($configurationMock, $httpClient, $requestFactory, $hydrator);

        $actualResponse = $winguApi->create(
            new Create(
                'Form component survey',
                'Thank you for your feedback!',
                new CreateResubmit(new BooleanValue(true), null)
            )
        );

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();
        self::assertSame('{"title":"Form component survey","feedbackSuccessMessage":"Thank you for your feedback!","resubmit":{"allowed":"1","allowedAfterSeconds":null}}', $actualRequest->getBody()->getContents());
        self::assertSame('POST', $actualRequest->getMethod());

        $expectedResponse = $this->getExpectedForm();
        self::assertEquals($expectedResponse, $actualResponse);
    }

    public function testUpdatePatchesFormComponent() : void
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

        $winguApi = new FormApi($configurationMock, $httpClient, $requestFactory, $hydrator);

        $winguApi->update(
            '05f21ca6-4b65-42a8-aea1-b21346a029a6',
            new Update(
                'Form component survey updated',
                null,
                new UpdateResubmit(new BooleanValue(true), null)
            )
        );

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();
        self::assertSame('{"title":"Form component survey updated","feedbackSuccessMessage":null,"resubmit":{"allowed":"1","allowedAfterSeconds":null}}', $actualRequest->getBody()->getContents());
        self::assertSame('PATCH', $actualRequest->getMethod());
    }

    private function getExpectedForm() : PrivateForm
    {
        return new PrivateForm(
            '05f21ca6-4b65-42a8-aea1-b21346a029a6',
            new \DateTime('2018-05-18T08:22:41+0000'),
            'Form component survey',
            'Thank you for your feedback!'
        );
    }
}
