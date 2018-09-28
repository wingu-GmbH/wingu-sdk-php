<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Tests\Api\Component\Rating;

use GuzzleHttp\Psr7\Response;
use Http\Mock\Client as MockClient;
use Psr\Http\Message\RequestInterface;
use Wingu\Engine\SDK\Api\Component\RatingApi;
use Wingu\Engine\SDK\Api\Configuration;
use Wingu\Engine\SDK\Model\Request\Component\Rating\Create;
use Wingu\Engine\SDK\Model\Request\Component\Rating\Statistic;
use Wingu\Engine\SDK\Model\Request\Component\Rating\Update;
use Wingu\Engine\SDK\Model\Response\Component\Rating;
use Wingu\Engine\SDK\Model\Response\Component\RatingRates;
use Wingu\Engine\SDK\Model\Response\Component\RatingStatistic;
use Wingu\Engine\SDK\Tests\Api\ApiTest;

class RatingApiTest extends ApiTest
{
    public function testCreateReturnsNewRatingComponent() : void
    {
        $configurationMock = new Configuration();

        $httpClient = new MockClient();
        $response   = new Response(
            201,
            ['Content-Type' => 'application/json'],
            $this->getDataFromFixturesFile('posted_rating_component.json')
        );
        $httpClient->addResponse($response);

        $winguApi = new RatingApi($configurationMock, $httpClient);

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

        $httpClient = new MockClient();
        $response   = new Response(
            204,
            ['Content-Type' => 'application/json']
        );
        $httpClient->addResponse($response);

        $winguApi = new RatingApi($configurationMock, $httpClient);

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

    public function testStatisticReturnsRatingStatistic() : void
    {
        $configurationMock = new Configuration();

        $httpClient = new MockClient();
        $httpClient->addResponse(
            new Response(
                200,
                ['Content-Type' => 'application/json'],
                $this->getDataFromFixturesFile('rating_statistic.json')
            )
        );

        $winguApi = new RatingApi($configurationMock, $httpClient);

        $actual   = $winguApi->statistic('a81700f1-83d1-4d1c-be86-37410b6a8d0a', new Statistic('8c798a67-0000-4000-a000-000000000001'));
        $expected = $this->getExpectedStatistic();

        self::assertEquals($expected, $actual);
    }

    private function getExpectedRating() : Rating
    {
        return new Rating(
            'bd6f204c-5b0f-41a2-9b48-c1cb4b394abe',
            new \DateTime('2018-09-07T11:45:23+0000'),
            'Rate me !'
        );
    }

    private function getExpectedStatistic() : RatingStatistic
    {
        return new RatingStatistic(
            new RatingRates(15, 19, 10, 26, 16, 3),
            new \DateTimeImmutable('2018-09-20T14:19:34.712Z')
        );
    }
}
