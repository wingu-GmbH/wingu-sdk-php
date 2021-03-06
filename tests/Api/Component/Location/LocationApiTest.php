<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Tests\Api\Component\Location;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Wingu\Engine\SDK\Api\Component\LocationApi;
use Wingu\Engine\SDK\Api\Configuration;
use Wingu\Engine\SDK\Model\Request\Component\Location\Coordinates as RequestCoordinates;
use Wingu\Engine\SDK\Model\Request\Component\Location\Create;
use Wingu\Engine\SDK\Model\Request\Component\Location\Update;
use Wingu\Engine\SDK\Model\Response\Component\Location;
use Wingu\Engine\SDK\Model\Response\Coordinates as ResponseCoordinates;
use Wingu\Engine\SDK\Tests\Api\ApiTest;

class LocationApiTest extends ApiTest
{
    public function testCreateReturnsNewLocationComponent() : void
    {
        $configurationMock = new Configuration();

        $httpClient = self::createClient();
        $response   = new Response(
            201,
            ['Content-Type' => 'application/json'],
            $this->getDataFromFixturesFile('posted_location_component.json')
        );
        $httpClient->addResponse($response);

        $winguApi = new LocationApi($configurationMock, $httpClient);

        $actualResponse = $winguApi->create(
            new Create(
                new RequestCoordinates(10.233362, 53.614503),
                602
            )
        );

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();
        self::assertSame(
            '{"coordinates":{"longitude":10.233362,"latitude":53.614503},"radius":602}',
            $actualRequest->getBody()->getContents()
        );
        self::assertSame('POST', $actualRequest->getMethod());

        $expectedResponse = $this->getExpectedLocation();
        self::assertEquals($expectedResponse, $actualResponse);
    }

    public function testUpdatePatchesLocationComponent() : void
    {
        $configurationMock = new Configuration();

        $httpClient = self::createClient();
        $response   = new Response(
            204,
            ['Content-Type' => 'application/json']
        );
        $httpClient->addResponse($response);

        $winguApi = new LocationApi($configurationMock, $httpClient);

        $winguApi->update(
            'ef9a3c06-8734-4a51-8205-083fe4e4b1cc',
            new Update(
                new RequestCoordinates(10.733362, 53.114503),
                618
            )
        );

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();
        self::assertSame(
            '{"coordinates":{"longitude":10.733362,"latitude":53.114503},"radius":618}',
            $actualRequest->getBody()->getContents()
        );
        self::assertSame('PATCH', $actualRequest->getMethod());
    }

    private function getExpectedLocation() : Location
    {
        return new Location(
            'ef9a3c06-8734-4a51-8205-083fe4e4b1cc',
            new \DateTime('2018-09-07T11:38:18+0000'),
            new ResponseCoordinates(10.233362, 53.614503),
            602
        );
    }
}
