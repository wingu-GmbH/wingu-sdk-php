<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Tests\Api\Component\Coupon;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Wingu\Engine\SDK\Api\Component\CouponApi;
use Wingu\Engine\SDK\Api\Configuration;
use Wingu\Engine\SDK\Model\Request\Component\Coupon\Barcode\Create as CreateBarcode;
use Wingu\Engine\SDK\Model\Request\Component\Coupon\Barcode\Update as UpdateBarcode;
use Wingu\Engine\SDK\Model\Request\Component\Coupon\Create;
use Wingu\Engine\SDK\Model\Request\Component\Coupon\Update;
use Wingu\Engine\SDK\Model\Request\StringValue;
use Wingu\Engine\SDK\Model\Response\Component\Coupon;
use Wingu\Engine\SDK\Model\Response\Component\CouponBarcode;
use Wingu\Engine\SDK\Model\Response\Component\Image;
use Wingu\Engine\SDK\Model\Response\Component\ImageMetadata;
use Wingu\Engine\SDK\Tests\Api\ApiTest;

final class CouponApiTest extends ApiTest
{
    public function testCreateReturnsNewCouponComponent() : void
    {
        $configurationMock = new Configuration();

        $httpClient = self::createClient();
        $response   = new Response(
            201,
            ['Content-Type' => 'application/json'],
            $this->getDataFromFixturesFile('posted_coupon_component.json')
        );
        $httpClient->addResponse($response);

        $winguApi = new CouponApi($configurationMock, $httpClient);

        $actualResponse = $winguApi->create(
            new Create(
                '-20 %',
                'Get you cheap stuff here!',
                new CreateBarcode('EAN_13', '4000161100348'),
                \GuzzleHttp\Psr7\stream_for(\fopen('examples/wingu_image.png', 'rb')),
                'Disclaimer'
            )
        );

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();

        self::assertStringStartsWith('multipart/form-data; boundary="', $actualRequest->getHeaderLine('Content-Type'));
        $actualRequestBody = $actualRequest->getBody()->getContents();
        self::assertContains('Content-Disposition: form-data; name="header"', $actualRequestBody);
        self::assertContains('Content-Disposition: form-data; name="description"', $actualRequestBody);
        self::assertContains('Content-Disposition: form-data; name="barcode[type]"', $actualRequestBody);
        self::assertContains('Content-Disposition: form-data; name="barcode[description]"', $actualRequestBody);
        self::assertContains('Content-Disposition: form-data; name="disclaimer"', $actualRequestBody);
        self::assertContains(
            'Content-Disposition: form-data; name="backgroundImage"; filename="wingu_image.png"',
            $actualRequestBody
        );
        self::assertSame('POST', $actualRequest->getMethod());

        $expectedResponse = $this->getExpectedCoupon();
        self::assertEquals($expectedResponse, $actualResponse);
    }

    public function testUpdatePatchesCouponComponent() : void
    {
        $configurationMock = new Configuration();

        $httpClient = self::createClient();
        $response   = new Response(
            204,
            ['Content-Type' => 'application/json']
        );
        $httpClient->addResponse($response);

        $winguApi = new CouponApi($configurationMock, $httpClient);

        $winguApi->update(
            '1557f82a-052e-4d6f-aa89-c67d1cc5bd9d',
            new Update(
                new StringValue('updated Coupon'),
                'Get your edited stuff here!',
                new UpdateBarcode('EAN_13', 'edited'),
                null,
                null
            )
        );

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();
        self::assertSame(
            '{"header":"updated Coupon","description":"Get your edited stuff here!","barcode":{"type":"EAN_13","description":"edited"}}',
            $actualRequest->getBody()->getContents()
        );
        self::assertSame('PATCH', $actualRequest->getMethod());
    }

    private function getExpectedCoupon() : Coupon
    {
        return new Coupon(
            '1557f82a-052e-4d6f-aa89-c67d1cc5bd9d',
            new \DateTime('2018-09-07T11:17:46+0000'),
            '-20 %',
            'Get you cheap stuff here!',
            'Disclaimer',
            new CouponBarcode('EAN_13', '4000161100348'),
            new Image(
                new ImageMetadata('jpg', 100, 50),
                'cloudinary_public_id',
                'cloudinary'
            )
        );
    }
}
