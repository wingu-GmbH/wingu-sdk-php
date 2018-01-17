<?php

declare(strict_types = 1);

namespace Wingu\Engine\SDK\Api\Channel;

use Wingu\Engine\SDK\Api\Api;
use Wingu\Engine\SDK\Api\Paginator\PageInfo;
use Wingu\Engine\SDK\Api\Paginator\PaginatedResponseIterator;
use Wingu\Engine\SDK\Model\Channel\PrivateChannel;

final class Channel extends Api
{
    public function myChannel(string $id): PrivateChannel
    {
        $request = $this->createGetRequest('/api/channel/my/' . $id . '.json');

        $response = $this->handleRequest($request);

        return $this->hydrator->hydrateResponse($response, PrivateChannel::class);
    }

    public function myChannels(): PaginatedResponseIterator
    {
        $page = $this->getEmbeddedPage('/api/channel/my.json');

        return new PaginatedResponseIterator(
            $page['pageInfo'],
            $page['embedded'],
            function (string $href) {
                return $this->getEmbeddedPage($href);
            }
        );
    }

    private function getEmbeddedPage(string $href)
    {
        $request = $this->createGetRequest($href);

        $response = $this->handleRequest($request);

        $data = $this->decodeResponseBody($response);

        $embedded = array_map(
            function ($data) {
                $discriminator = \key($data);
                $data = \reset($data);
                $data['discriminator'] = $discriminator;

                return $data;
            },
            $data['_embedded']['channels']
        );

        $pageInfo = $this->hydrator->hydrateData($data, PageInfo::class);
        $embedded = $this->hydrator->hydrateData(
            $embedded,
            PrivateChannel::class . '[]'
        );

        return ['pageInfo' => $pageInfo, 'embedded' => $embedded];
    }
}
