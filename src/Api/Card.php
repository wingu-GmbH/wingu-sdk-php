<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Api;

use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\Card as RequestCard;
use Wingu\Engine\SDK\Model\Response\Card\Card as ResponseCard;

final class Card extends Api
{
    public function addCardToDeck(RequestCard $card) : ResponseCard
    {
        $request = $this->createPostRequest('/api/card', $card);

        $response = $this->handleRequest($request);

        return $this->hydrator->hydrateResponse($response, ResponseCard::class);
    }

    public function deleteMyCard(string $id) : void
    {
        Assertion::uuid($id);
        $request = $this->createDeleteRequest('/api/card/' . $id);

        $this->handleRequest($request);
    }
}
