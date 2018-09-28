<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Api\Component;

use Wingu\Engine\SDK\Api\Api;
use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\Component\Coupon\Create;
use Wingu\Engine\SDK\Model\Request\Component\Coupon\Update;
use Wingu\Engine\SDK\Model\Response\Component\Coupon;

final class CouponApi extends Api
{
    public function create(Create $coupon) : Coupon
    {
        if ($coupon->files() === []) {
            $request = $this->createPostRequest('/api/component/coupon', $coupon);
        } else {
            $request = $this->createMultipartPostRequest('/api/component/coupon', $coupon);
        }

        $response = $this->handleRequest($request);

        return $this->hydrator->hydrateResponse($response, Coupon::class);
    }

    public function update(string $id, Update $coupon) : void
    {
        Assertion::uuid($id);

        if ($coupon->files() === []) {
            $request = $this->createPatchRequest('/api/component/coupon/' . $id, $coupon);
        } else {
            $request = $this->createMultipartPatchRequest('/api/component/coupon/' . $id, $coupon);
        }

        $this->handleRequest($request);
    }
}
