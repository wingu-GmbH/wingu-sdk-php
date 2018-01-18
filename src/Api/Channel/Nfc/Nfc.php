<?php

declare(strict_types = 1);

namespace Wingu\Engine\SDK\Api\Channel\Nfc;

use Wingu\Engine\SDK\Api\Api;
use Wingu\Engine\SDK\Model\Channel\Nfc\PrivateNfc as PrivateNfcModel;
use Wingu\Engine\SDK\Model\Channel\Nfc\PublicNfc as PublicNfcModel;

final class Nfc extends Api
{
    public function nfc(string $id): PublicNfcModel
    {
        $request = $this->createGetRequest('/api/channel/nfc/' . $id . '.json');

        $response = $this->handleRequest($request);

        return $this->hydrator->hydrateResponse($response, PublicNfcModel::class);
    }

    public function myNfc(string $id): PrivateNfcModel
    {
        $request = $this->createGetRequest('/api/channel/nfc/my/' . $id . '.json');

        $response = $this->handleRequest($request);

        return $this->hydrator->hydrateResponse($response, PrivateNfcModel::class);
    }

    public function payload(string $payload): string
    {
        $request = $this->createGetRequest('/api/channel/nfc/payload.json', ['payload' => $payload]);

        $response = $this->handleRequest($request);

        $data = $this->decodeResponseBody($response);

        return $data['id'];
    }
}
