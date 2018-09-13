<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Api\Channel\Beacon;

use Wingu\Engine\SDK\Api\Api;
use Wingu\Engine\SDK\Api\Paginator\EmbeddedPage;
use Wingu\Engine\SDK\Api\Paginator\PageInfo;
use Wingu\Engine\SDK\Api\Paginator\PaginatedResponseIterator;
use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\Channel\Beacon\PrivateBeacon as RequestPrivateBeacon;
use Wingu\Engine\SDK\Model\Request\Channel\Beacon\PublicBeaconLocation as RequestPublicBeacon;
use Wingu\Engine\SDK\Model\Response\Channel\Beacon\PrivateBeacon as PrivateBeaconModel;
use Wingu\Engine\SDK\Model\Response\Channel\Beacon\PublicBeacon as PublicBeaconModel;

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

    public function myBeacons() : PaginatedResponseIterator
    {
        $page = $this->getEmbeddedPage('/api/channel/beacon/my.json');

        return new PaginatedResponseIterator(
            $page->pageInfo(),
            $page->embedded(),
            function (string $href) {
                return $this->getEmbeddedPage($href);
            }
        );
    }

    public function updateBeaconLocation(string $id, RequestPublicBeacon $beacon) : void
    {
        Assertion::uuid($id);

        $request = $this->createPostRequest('/api/channel/beacon/' . $id . '/location', $beacon);

        $this->handleRequest($request);
    }

    public function updateMyBeacon(string $id, RequestPrivateBeacon $beacon) : void
    {
        Assertion::uuid($id);

        $request = $this->createPatchRequest('/api/channel/beacon/my/' . $id, $beacon);

        $this->handleRequest($request);
    }

    public function deleteMyBeacon(string $id) : void
    {
        Assertion::uuid($id);
        $request = $this->createDeleteRequest('/api/channel/beacon/my/' . $id);

        $this->handleRequest($request);
    }

    private function getEmbeddedPage(string $href) : EmbeddedPage
    {
        $request = $this->createGetRequest($href);

        $response = $this->handleRequest($request);

        $data = $this->decodeResponseBody($response);

        $pageInfo = $this->hydrator->hydrateData($data, PageInfo::class);
        $embedded = $this->hydrator->hydrateData(
            \array_column($data['_embedded']['beacons'], 'beacon'),
            PrivateBeaconModel::class . '[]'
        );

        return new EmbeddedPage($pageInfo, $embedded);
    }
}
