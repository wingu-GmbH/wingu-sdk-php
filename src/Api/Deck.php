<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Api;

use Wingu\Engine\SDK\Model\Request\Deck\Deck as RequestDeck;
use Wingu\Engine\SDK\Model\Response\Content\Deck as ResponseDeck;

final class Deck extends Api
{
    public function createDeck(RequestDeck $deck) : ResponseDeck
    {
        $request = $this->createPostRequest('/api/deck', $deck);

        $response = $this->handleRequest($request);

        return $this->hydrator->hydrateResponse($response, ResponseDeck::class);
    }
}
