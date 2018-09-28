<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Api;

use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\Deck\CardsPosition;
use Wingu\Engine\SDK\Model\Request\Deck\Create;
use Wingu\Engine\SDK\Model\Request\Deck\Update;
use Wingu\Engine\SDK\Model\Response\Content\Deck as ResponseDeck;

final class Deck extends Api
{
    public function createDeck(Create $deck) : ResponseDeck
    {
        $request = $this->createPostRequest('/api/deck', $deck);

        $response = $this->handleRequest($request);

        return $this->hydrator->hydrateResponse($response, ResponseDeck::class);
    }

    public function myDeck(string $id) : ResponseDeck
    {
        $request = $this->createGetRequest('/api/deck/my/' . $id . '.json');

        $response = $this->handleRequest($request);

        return $this->hydrator->hydrateResponse($response, ResponseDeck::class);
    }

    public function updateMyDeck(string $id, Update $deck) : void
    {
        Assertion::uuid($id);
        $request = $this->createPatchRequest('/api/deck/my/' . $id, $deck);

        $this->handleRequest($request);
    }

    public function updateCardsPosition(string $id, CardsPosition $cardsPosition) : void
    {
        Assertion::uuid($id);
        $request = $this->createPutRequest('/api/deck/my/' . $id . '/cards_position', $cardsPosition);
        $this->handleRequest($request);
    }

    public function deleteMyDeck(string $id) : void
    {
        Assertion::uuid($id);
        $request = $this->createDeleteRequest('/api/deck/my/' . $id);

        $this->handleRequest($request);
    }
}
