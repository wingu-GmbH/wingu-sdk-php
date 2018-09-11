<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Api\Component;

use Wingu\Engine\SDK\Api\Api;
use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\Component\Rating\Create;
use Wingu\Engine\SDK\Model\Request\Component\Rating\Update;
use Wingu\Engine\SDK\Model\Response\Component\Rating;

final class RatingApi extends Api
{
    public function create(Create $rating) : Rating
    {
        $request = $this->createPostRequest('/api/component/rating', $rating);

        $response = $this->handleRequest($request);

        return $this->hydrator->hydrateResponse($response, Rating::class);
    }

    public function update(string $id, Update $rating) : void
    {
        Assertion::uuid($id);
        $request = $this->createPatchRequest('/api/component/rating/' . $id, $rating);

        $this->handleRequest($request);
    }
}
