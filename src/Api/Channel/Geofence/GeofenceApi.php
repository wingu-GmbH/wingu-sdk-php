<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Api\Channel\Geofence;

use Wingu\Engine\SDK\Api\Api;
use Wingu\Engine\SDK\Api\Paginator\EmbeddedPage;
use Wingu\Engine\SDK\Api\Paginator\PageInfo;
use Wingu\Engine\SDK\Api\Paginator\PaginatedResponseIterator;
use Wingu\Engine\SDK\Model\Response\Channel\Geofence\PrivateGeofence as PrivateGeofenceModel;
use Wingu\Engine\SDK\Model\Response\Channel\Geofence\PublicGeofence as PublicGeofenceModel;

final class GeofenceApi extends Api
{
    public function geofence(string $id) : PublicGeofenceModel
    {
        $request = $this->createGetRequest('/api/channel/geofence/' . $id . '.json');

        $response = $this->handleRequest($request);

        return $this->hydrator->hydrateResponse($response, PublicGeofenceModel::class);
    }

    public function myGeofence(string $id) : PrivateGeofenceModel
    {
        $request = $this->createGetRequest('/api/channel/geofence/my/' . $id . '.json');

        $response = $this->handleRequest($request);

        return $this->hydrator->hydrateResponse($response, PrivateGeofenceModel::class);
    }

    public function myGeofences() : PaginatedResponseIterator
    {
        $page = $this->getEmbeddedPage('/api/channel/geofence/my.json');

        return new PaginatedResponseIterator(
            $page->pageInfo(),
            $page->embedded(),
            function (string $href) {
                return $this->getEmbeddedPage($href);
            }
        );
    }

    private function getEmbeddedPage(string $href) : EmbeddedPage
    {
        $request = $this->createGetRequest($href);

        $response = $this->handleRequest($request);

        $data = $this->decodeResponseBody($response);

        $pageInfo = $this->hydrator->hydrateData($data, PageInfo::class);
        $embedded = $this->hydrator->hydrateData(
            \array_column($data['_embedded']['geofences'], 'geofence'),
            PrivateGeofenceModel::class . '[]'
        );

        return new EmbeddedPage($pageInfo, $embedded);
    }
}
