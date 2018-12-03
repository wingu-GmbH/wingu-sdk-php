<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Tests\Api\Component\Form;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Wingu\Engine\SDK\Api\Component\FormApi;
use Wingu\Engine\SDK\Api\Configuration;
use Wingu\Engine\SDK\Model\Request\BooleanValue;
use Wingu\Engine\SDK\Model\Request\Component\Form\Create;
use Wingu\Engine\SDK\Model\Request\Component\Form\Element\Input as RequestInput;
use Wingu\Engine\SDK\Model\Request\Component\Form\Element\Select as RequestSelect;
use Wingu\Engine\SDK\Model\Request\Component\Form\Element\SelectOption as RequestSelectOption;
use Wingu\Engine\SDK\Model\Request\Component\Form\Resubmit\Create as CreateResubmit;
use Wingu\Engine\SDK\Model\Request\Component\Form\Resubmit\Update as UpdateResubmit;
use Wingu\Engine\SDK\Model\Request\Component\Form\SubmitDestination\Email as RequestEmail;
use Wingu\Engine\SDK\Model\Request\Component\Form\SubmitDestination\Endpoint as RequestEndpoint;
use Wingu\Engine\SDK\Model\Request\Component\Form\Update;
use Wingu\Engine\SDK\Tests\Api\ApiTest;
use Wingu\Engine\SDK\Tests\Api\Expected\Loader\PrivateComponent;

final class FormApiTest extends ApiTest
{
    use PrivateComponent;

    public function testCreateReturnsNewFormComponent() : void
    {
        $configurationMock = new Configuration();

        $httpClient = self::createClient();
        $response   = new Response(
            201,
            ['Content-Type' => 'application/json'],
            $this->getDataFromFixturesFile('posted_form_component.json')
        );
        $httpClient->addResponse($response);

        $winguApi = new FormApi($configurationMock, $httpClient);

        $actualResponse = $winguApi->create(
            new Create(
                'Form component survey',
                [
                    new RequestInput('first', 'First input', true, 'text'),
                    new RequestInput('second', 'Second input', true, 'text'),
                    new RequestSelect(
                        'select',
                        'First select',
                        true,
                        false,
                        [
                            new RequestSelectOption('option one', 'one'),
                            new RequestSelectOption('option two', 'two'),
                        ]
                    ),
                ],
                'Thank you for your feedback!',
                [
                    new RequestEndpoint('https://www.wingu.de', []),
                    new RequestEmail('hilfe@wingu.de'),
                ],
                new CreateResubmit(new BooleanValue(true), null)
            )
        );

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();
        self::assertSame(
            '{"title":"Form component survey","elements":[{"name":"first","label":"First input","required":true,"type":"text","discriminator":"input"},{"name":"second","label":"Second input","required":true,"type":"text","discriminator":"input"},{"name":"select","label":"First select","required":true,"multiple":false,"options":[{"label":"option one","value":"one"},{"label":"option two","value":"two"}],"discriminator":"select"}],"feedbackSuccessMessage":"Thank you for your feedback!","submitDestinations":[{"url":"https:\/\/www.wingu.de","headers":[],"discriminator":"endpoint"},{"email":"hilfe@wingu.de","discriminator":"email"}],"resubmit":{"allowed":"1","allowedAfterSeconds":null}}',
            $actualRequest->getBody()->getContents()
        );
        self::assertSame('POST', $actualRequest->getMethod());

        $expectedResponse = $this->getExpectedFormComponent();
        self::assertEquals($expectedResponse, $actualResponse);
    }

    public function testUpdatePatchesFormComponent() : void
    {
        $configurationMock = new Configuration();

        $httpClient = self::createClient();
        $response   = new Response(
            204,
            ['Content-Type' => 'application/json']
        );
        $httpClient->addResponse($response);

        $winguApi = new FormApi($configurationMock, $httpClient);

        $winguApi->update(
            '05f21ca6-4b65-42a8-aea1-b21346a029a6',
            new Update(
                'Form component survey updated',
                [
                    new RequestInput('first', 'Updated first input', false, 'text'),
                ],
                'Feedback message update',
                [
                    new RequestEndpoint('https://www.wingu.de', []),
                ],
                new UpdateResubmit(new BooleanValue(true), null)
            )
        );

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();
        self::assertSame(
            '{"title":"Form component survey updated","elements":[{"name":"first","label":"Updated first input","required":false,"type":"text","discriminator":"input"}],"feedbackSuccessMessage":"Feedback message update","submitDestinations":[{"url":"https:\/\/www.wingu.de","headers":[],"discriminator":"endpoint"}],"resubmit":{"allowed":"1","allowedAfterSeconds":null}}',
            $actualRequest->getBody()->getContents()
        );
        self::assertSame('PATCH', $actualRequest->getMethod());
    }
}
