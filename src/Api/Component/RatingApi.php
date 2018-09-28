<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Api\Component;

use Wingu\Engine\SDK\Api\Api;
use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\Component\Rating\Create;
use Wingu\Engine\SDK\Model\Request\Component\Rating\Rate;
use Wingu\Engine\SDK\Model\Request\Component\Rating\Statistic;
use Wingu\Engine\SDK\Model\Request\Component\Rating\Update;
use Wingu\Engine\SDK\Model\Response\Component\Rating;
use Wingu\Engine\SDK\Model\Response\Component\RatingStatistic;

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

    public function createRate(string $id, Rate $rate) : void
    {
        Assertion::uuid($id);
        $request = $this->createPostRequest('/api/component/rating/' . $id . '/rate', $rate);

        $this->handleRequest($request);
    }

    public function statistic(string $id, Statistic $statistic) : RatingStatistic
    {
        $request = $this->createGetRequest('/api/component/rating/' . $id . '/statistic', $statistic->toArray());

        $response = $this->handleRequest($request);

        return $this->hydrator->hydrateResponse($response, RatingStatistic::class);
    }
}
