<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Tests\Api\Component\Rating;

use GuzzleHttp\Psr7\Response;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use Http\Mock\Client as MockClient;
use Psr\Http\Message\RequestInterface;
use Wingu\Engine\SDK\Api\Component\RatingApi;
use Wingu\Engine\SDK\Api\Configuration;
use Wingu\Engine\SDK\Hydrator\SymfonySerializerHydrator;
use Wingu\Engine\SDK\Model\Request\Component\Rating\Create;
use Wingu\Engine\SDK\Model\Request\Component\Rating\Update;
use Wingu\Engine\SDK\Model\Response\Component\Rating;
use Wingu\Engine\SDK\Tests\Api\ApiTest;

class RatingApiTest extends ApiTest
{
    public function testCreateReturnsNewRatingComponent() : void
    {
        $configurationMock = new Configuration();
        $requestFactory    = new GuzzleMessageFactory();
        $hydrator          = new SymfonySerializerHydrator();

        $httpClient = new MockClient();
        $response   = new Response(
            201,
            ['Content-Type' => 'application/json'],
            $this->getDataFromFixturesFile('posted_rating_component.json')
        );
        $httpClient->addResponse($response);

        $winguApi = new RatingApi($configurationMock, $httpClient, $requestFactory, $hydrator);

        $actualResponse = $winguApi->create(
            new Create(
                'Rate me !'
            )
        );

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();
        self::assertSame('{"title":"Rate me !"}', $actualRequest->getBody()->getContents());
        self::assertSame('POST', $actualRequest->getMethod());

        $expectedResponse = $this->getExpectedRating();
        self::assertEquals($expectedResponse, $actualResponse);
    }

    public function testUpdatePatchesRatingComponent() : void
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

        $winguApi = new RatingApi($configurationMock, $httpClient, $requestFactory, $hydrator);

        $winguApi->update(
            'bd6f204c-5b0f-41a2-9b48-c1cb4b394abe',
            new Update(
                'Rate me please !'
            )
        );

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();
        self::assertSame('{"title":"Rate me please !"}', $actualRequest->getBody()->getContents());
        self::assertSame('PATCH', $actualRequest->getMethod());
    }

    private function getExpectedRating() : Rating
    {
        return new Rating(
            'bd6f204c-5b0f-41a2-9b48-c1cb4b394abe',
            new \DateTime('2018-09-07T11:45:23+0000'),
            'Rate me !'
        );
    }
}
