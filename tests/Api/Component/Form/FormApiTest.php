<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Tests\Api\Component\Form;

use GuzzleHttp\Psr7\Response;
use Http\Mock\Client as MockClient;
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
use Wingu\Engine\SDK\Model\Response\Component\Element\Input;
use Wingu\Engine\SDK\Model\Response\Component\Element\Select;
use Wingu\Engine\SDK\Model\Response\Component\Element\SelectOption;
use Wingu\Engine\SDK\Model\Response\Component\PrivateForm;
use Wingu\Engine\SDK\Model\Response\Component\SubmitDestination\Email;
use Wingu\Engine\SDK\Model\Response\Component\SubmitDestination\Endpoint;
use Wingu\Engine\SDK\Tests\Api\ApiTest;

class FormApiTest extends ApiTest
{
    public function testCreateReturnsNewFormComponent() : void
    {
        $configurationMock = new Configuration();

        $httpClient = new MockClient();
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

        $expectedResponse = $this->getExpectedForm();
        self::assertEquals($expectedResponse, $actualResponse);
    }

    public function testUpdatePatchesFormComponent() : void
    {
        $configurationMock = new Configuration();

        $httpClient = new MockClient();
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

    private function getExpectedForm() : PrivateForm
    {
        return new PrivateForm(
            '05f21ca6-4b65-42a8-aea1-b21346a029a6',
            new \DateTime('2018-05-18T08:22:41+0000'),
            'Form component survey',
            [
                new Input('full_name', 'Your name', true, 'text'),
                new Input('birthday', 'Birthday', false, 'date'),
                new Select(
                    'gender',
                    'Gender',
                    false,
                    false,
                    [
                        new SelectOption('Male', 'm'),
                        new SelectOption('Female', 'f'),
                    ]
                ),
                new Select(
                    'dessert',
                    'Dessert',
                    true,
                    true,
                    [
                        new SelectOption('Jello', 'jello'),
                        new SelectOption('Apple pie', 'apple_pie'),
                        new SelectOption('Schnitzel', 'schnitzel'),
                    ]
                ),
                new Input('text', 'Element text', false, 'text'),
                new Input('textarea', 'Element textarea', false, 'textarea'),
                new Input('email', 'Element email', false, 'email'),
                new Input('url', 'Element url', false, 'url'),
                new Input('date', 'Element date', false, 'date'),
                new Input('datetime', 'Element datetime', false, 'datetime'),
                new Input('time', 'Element time', false, 'time'),
            ],
            [
                new Email('test+form-component@wingu.de'),
                new Endpoint('https://httpbin.org/status/200', []),
            ],
            'Thank you for your feedback!'
        );
    }
}
