<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Tests\Api\Component\Coupon;

use GuzzleHttp\Psr7\Response;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use Http\Mock\Client as MockClient;
use Psr\Http\Message\RequestInterface;
use Wingu\Engine\SDK\Api\Component\CouponApi;
use Wingu\Engine\SDK\Api\Configuration;
use Wingu\Engine\SDK\Hydrator\SymfonySerializerHydrator;
use Wingu\Engine\SDK\Model\Request\Component\Coupon\Barcode\Create as CreateBarcode;
use Wingu\Engine\SDK\Model\Request\Component\Coupon\Barcode\Update as UpdateBarcode;
use Wingu\Engine\SDK\Model\Request\Component\Coupon\Create;
use Wingu\Engine\SDK\Model\Request\Component\Coupon\Update;
use Wingu\Engine\SDK\Model\Response\Component\Coupon;
use Wingu\Engine\SDK\Tests\Api\ApiTest;

class CouponApiTest extends ApiTest
{
    public function testCreateReturnsNewCouponComponent() : void
    {
        $configurationMock = new Configuration();
        $requestFactory    = new GuzzleMessageFactory();
        $hydrator          = new SymfonySerializerHydrator();

        $httpClient = new MockClient();
        $response   = new Response(
            201,
            ['Content-Type' => 'application/json'],
            $this->getDataFromFixturesFile('posted_coupon_component.json')
        );
        $httpClient->addResponse($response);

        $winguApi = new CouponApi($configurationMock, $httpClient, $requestFactory, $hydrator);

        $actualResponse = $winguApi->create(
            new Create(
                '-20 %',
                'Get you cheap stuff here!',
                new CreateBarcode('EAN_13', '4000161100348'),
                'Disclaimer'
            )
        );

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();
        self::assertSame('{"header":"-20 %","description":"Get you cheap stuff here!","barcode":{"type":"EAN_13","description":"4000161100348"},"disclaimer":"Disclaimer"}', $actualRequest->getBody()->getContents());
        self::assertSame('POST', $actualRequest->getMethod());

        $expectedResponse = $this->getExpectedCoupon();
        self::assertEquals($expectedResponse, $actualResponse);
    }

    public function testUpdatePatchesCouponComponent() : void
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

        $winguApi = new CouponApi($configurationMock, $httpClient, $requestFactory, $hydrator);

        $winguApi->update(
            '1557f82a-052e-4d6f-aa89-c67d1cc5bd9d',
            new Update(
                'updated Coupon',
                'Get your edited stuff here!',
                new UpdateBarcode('EAN_13', 'edited'),
                null
            )
        );

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();
        self::assertSame('{"header":"updated Coupon","description":"Get your edited stuff here!","barcode":{"type":"EAN_13","description":"edited"},"disclaimer":null}', $actualRequest->getBody()->getContents());
        self::assertSame('PATCH', $actualRequest->getMethod());
    }

    private function getExpectedCoupon() : Coupon
    {
        return new Coupon(
            '1557f82a-052e-4d6f-aa89-c67d1cc5bd9d',
            new \DateTime('2018-09-07T11:17:46+0000'),
            '-20 %',
            'Get you cheap stuff here!',
            'Disclaimer'
        );
    }
}
