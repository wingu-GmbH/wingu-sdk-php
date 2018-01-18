<?php

declare(strict_types = 1);

namespace Wingu\Engine\SDK\Api\Channel\Geofence;

use Wingu\Engine\SDK\Api\Api;
use Wingu\Engine\SDK\Model\Channel\Geofence\PrivateGeofence as PrivateGeofenceModel;
use Wingu\Engine\SDK\Model\Channel\Geofence\PublicGeofence as PublicGeofenceModel;

final class Geofence extends Api
{
    public function geofence(string $id): PublicGeofenceModel
    {
        $request = $this->createGetRequest('/api/channel/geofence/' . $id . '.json');

        $response = $this->handleRequest($request);

        return $this->hydrator->hydrateResponse($response, PublicGeofenceModel::class);
    }

    public function myGeofence(string $id): PrivateGeofenceModel
    {
        $request = $this->createGetRequest('/api/channel/geofence/my/' . $id . '.json');

        $response = $this->handleRequest($request);

        return $this->hydrator->hydrateResponse($response, PrivateGeofenceModel::class);
    }
}
