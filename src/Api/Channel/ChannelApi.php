<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Api\Channel;

use Wingu\Engine\SDK\Api\Api;
use Wingu\Engine\SDK\Api\Paginator\EmbeddedPage;
use Wingu\Engine\SDK\Api\Paginator\PageInfo;
use Wingu\Engine\SDK\Api\Paginator\PaginatedResponseIterator;
use Wingu\Engine\SDK\Model\Request\Channel\PrivateChannelsFilter;
use Wingu\Engine\SDK\Model\Request\Channel\PrivateChannelsSorting;
use Wingu\Engine\SDK\Model\Response\Channel\PrivateChannel;

final class ChannelApi extends Api
{
    public function myChannel(string $id) : PrivateChannel
    {
        $request = $this->createGetRequest('/api/channel/my/' . $id . '.json');

        $response = $this->handleRequest($request);

        return $this->hydrator->hydrateResponse($response, PrivateChannel::class);
    }

    public function myChannels(?PrivateChannelsFilter $channelsFilter = null, ?PrivateChannelsSorting $channelsSorting = null) : PaginatedResponseIterator
    {
        $page = $this->getEmbeddedPage('/api/channel/my.json', $channelsFilter, $channelsSorting);

        return new PaginatedResponseIterator(
            $page->pageInfo(),
            $page->embedded(),
            function (string $href) {
                return $this->getEmbeddedPage($href);
            }
        );
    }

    private function getEmbeddedPage(string $href, ?PrivateChannelsFilter $channelsFilter = null, ?PrivateChannelsSorting $channelsSorting = null) : EmbeddedPage
    {
        $params = [];

        if ($channelsFilter !== null) {
            $params['filter'] = $channelsFilter->toArray();
        }
        if ($channelsSorting !== null) {
            $params['sorting'] = $channelsSorting->toArray();
        }

        $request = $this->createGetRequest($href, $params);

        $response = $this->handleRequest($request);

        $data = $this->decodeResponseBody($response);

        $embedded = \array_map(
            function ($data) {
                $discriminator         = \key($data);
                $data                  = \reset($data);
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

        return new EmbeddedPage($pageInfo, $embedded);
    }
}
