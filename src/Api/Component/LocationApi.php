<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Api\Component;

use Wingu\Engine\SDK\Api\Api;
use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\Component\Location\Create;
use Wingu\Engine\SDK\Model\Request\Component\Location\Update;
use Wingu\Engine\SDK\Model\Response\Component\Location;

final class LocationApi extends Api
{
    public function create(Create $location) : Location
    {
        $request = $this->createPostRequest('/api/component/location', $location);

        $response = $this->handleRequest($request);

        return $this->hydrator->hydrateResponse($response, Location::class);
    }

    public function update(string $id, Update $location) : void
    {
        Assertion::uuid($id);
        $request = $this->createPatchRequest('/api/component/location/' . $id, $location);

        $this->handleRequest($request);
    }
}
