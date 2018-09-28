<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Tests\Api\Component\SurveyMonkey;

use GuzzleHttp\Psr7\Response;
use Http\Mock\Client as MockClient;
use Psr\Http\Message\RequestInterface;
use Wingu\Engine\SDK\Api\Component\SurveyMonkeyApi;
use Wingu\Engine\SDK\Api\Configuration;
use Wingu\Engine\SDK\Model\Request\Component\SurveyMonkey\Create;
use Wingu\Engine\SDK\Model\Request\Component\SurveyMonkey\Update;
use Wingu\Engine\SDK\Model\Request\StringValue;
use Wingu\Engine\SDK\Model\Response\Component\SurveyMonkey;
use Wingu\Engine\SDK\Tests\Api\ApiTest;

class SurveyMonkeyApiTest extends ApiTest
{
    public function testCreateReturnsNewSurveyMonkeyComponent() : void
    {
        $configurationMock = new Configuration();

        $httpClient = new MockClient();
        $response   = new Response(
            201,
            ['Content-Type' => 'application/json'],
            $this->getDataFromFixturesFile('posted_survey_monkey_component.json')
        );
        $httpClient->addResponse($response);

        $winguApi = new SurveyMonkeyApi($configurationMock, $httpClient);

        $actualResponse = $winguApi->create(
            new Create(
                'Take the IQ survey',
                'You will probably fail',
                'https://de.surveymonkey.com/r/5FBK8Z3'
            )
        );

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();
        self::assertSame('{"title":"Take the IQ survey","description":"You will probably fail","surveyURL":"https:\/\/de.surveymonkey.com\/r\/5FBK8Z3"}', $actualRequest->getBody()->getContents());
        self::assertSame('POST', $actualRequest->getMethod());

        $expectedResponse = $this->getExpectedSurveyMonkey();
        self::assertEquals($expectedResponse, $actualResponse);
    }

    public function testUpdatePatchesSurveyMonkeyComponent() : void
    {
        $configurationMock = new Configuration();

        $httpClient = new MockClient();
        $response   = new Response(
            204,
            ['Content-Type' => 'application/json']
        );
        $httpClient->addResponse($response);

        $winguApi = new SurveyMonkeyApi($configurationMock, $httpClient);

        $winguApi->update(
            '261a7aab-4b03-4817-b471-060c2e046826',
            new Update(
                null,
                new StringValue('You will probably pass'),
                null
            )
        );

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();
        self::assertSame('{"description":"You will probably pass"}', $actualRequest->getBody()->getContents());
        self::assertSame('PATCH', $actualRequest->getMethod());
    }

    private function getExpectedSurveyMonkey() : SurveyMonkey
    {
        return new SurveyMonkey(
            '3fafd116-4e03-469c-a28d-035ca17fc46e',
            new \DateTime('2018-09-07T11:52:29+0000'),
            'Take the IQ survey',
            'You will probably fail',
            'https://de.surveymonkey.com/r/5FBK8Z3'
        );
    }
}
