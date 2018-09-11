<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Api\Component;

use Wingu\Engine\SDK\Api\Api;
use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\Component\CMS\Create;
use Wingu\Engine\SDK\Model\Request\Component\CMS\Update;
use Wingu\Engine\SDK\Model\Response\Component\CMS;

final class CMSApi extends Api
{
    public function create(Create $cms) : CMS
    {
        $request = $this->createPostRequest('/api/component/cms', $cms);

        $response = $this->handleRequest($request);

        return $this->hydrator->hydrateResponse($response, CMS::class);
    }

    public function update(string $id, Update $cms) : void
    {
        Assertion::uuid($id);
        $request = $this->createPatchRequest('/api/component/cms/' . $id, $cms);

        $this->handleRequest($request);
    }
}
