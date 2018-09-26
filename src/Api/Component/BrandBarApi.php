<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Api\Component;

use Wingu\Engine\SDK\Api\Api;
use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\Component\BrandBar\Create;
use Wingu\Engine\SDK\Model\Request\Component\BrandBar\Update;
use Wingu\Engine\SDK\Model\Response\Component\BrandBar;

final class BrandBarApi extends Api
{
    public function create(Create $brandBar) : BrandBar
    {
        $request = $this->createMultipartPostRequest('/api/component/brand_bar', $brandBar);

        $response = $this->handleRequest($request);

        return $this->hydrator->hydrateResponse($response, BrandBar::class);
    }

    public function update(string $id, Update $brandBar) : void
    {
        Assertion::uuid($id);

        if ($brandBar->files() === []) {
            $request = $this->createPatchRequest('/api/component/brand_bar/' . $id, $brandBar);
        } else {
            $request = $this->createMultipartPatchRequest('/api/component/brand_bar/' . $id, $brandBar);
        }

        $this->handleRequest($request);
    }
}
