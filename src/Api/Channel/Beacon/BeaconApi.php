<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Api\Channel\Beacon;

use Wingu\Engine\SDK\Api\Api;
use Wingu\Engine\SDK\Model\Channel\Beacon\PrivateBeacon as PrivateBeaconModel;
use Wingu\Engine\SDK\Model\Channel\Beacon\PublicBeacon as PublicBeaconModel;

final class BeaconApi extends Api
{
    public function beacon(string $id) : PublicBeaconModel
    {
        $request = $this->createGetRequest('/api/channel/beacon/' . $id . '.json');

        $response = $this->handleRequest($request);

        return $this->hydrator->hydrateResponse($response, PublicBeaconModel::class);
    }

    public function myBeacon(string $id) : PrivateBeaconModel
    {
        $request = $this->createGetRequest('/api/channel/beacon/my/' . $id . '.json');

        $response = $this->handleRequest($request);

        return $this->hydrator->hydrateResponse($response, PrivateBeaconModel::class);
    }

    public function eddystone(string $url) : string
    {
        $request = $this->createGetRequest('/api/channel/beacon/eddystone.json', ['url' => $url]);

        $response = $this->handleRequest($request);

        $data = $this->decodeResponseBody($response);

        return $data['id'];
    }
}
