<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Api\Channel;

use Wingu\Engine\SDK\Api\Api;
use Wingu\Engine\SDK\Api\Paginator\EmbeddedPage;
use Wingu\Engine\SDK\Api\Paginator\PageInfo;
use Wingu\Engine\SDK\Api\Paginator\PaginatedResponseIterator;
use Wingu\Engine\SDK\Model\Request\Channel\PrivateChannelsFilter;
use Wingu\Engine\SDK\Model\Request\Channel\PrivateChannelsSorting;
use Wingu\Engine\SDK\Model\Request\PaginationParameters;
use Wingu\Engine\SDK\Model\Response\Channel\PrivateChannel;

final class ChannelApi extends Api
{
    public function myChannel(string $id) : PrivateChannel
    {
        $request = $this->createGetRequest('/api/channel/my/' . $id . '.json');

        $response = $this->handleRequest($request);

        return $this->hydrator->hydrateResponse($response, PrivateChannel::class);
    }

    public function myChannels(
        ?PrivateChannelsFilter $channelsFilter = null,
        ?PrivateChannelsSorting $channelsSorting = null
    ) : PaginatedResponseIterator {
        $page = $this->getMyChannelsPage(null, $channelsFilter, $channelsSorting);

        return new PaginatedResponseIterator(
            $page->pageInfo(),
            $page->embedded(),
            function (string $href) {
                $path = \parse_url($href, \PHP_URL_PATH);
                \parse_str(\parse_url($href, \PHP_URL_QUERY) ?? '', $query);

                return $this->getEmbeddedPage($path, $query);
            }
        );
    }

    public function myChannelsPage(
        PaginationParameters $paginationParameters,
        ?PrivateChannelsFilter $channelsFilter = null,
        ?PrivateChannelsSorting $channelsSorting = null
    ) : EmbeddedPage {
        return $this->getMyChannelsPage($paginationParameters, $channelsFilter, $channelsSorting);
    }

    private function getMyChannelsPage(
        ?PaginationParameters $paginationParameters,
        ?PrivateChannelsFilter $channelsFilter,
        ?PrivateChannelsSorting $channelsSorting
    ) : EmbeddedPage {
        $params = [];

        if ($paginationParameters !== null) {
            $params = $paginationParameters->toArray();
        }
        if ($channelsFilter !== null) {
            $params['filter'] = $channelsFilter->toArray();
        }
        if ($channelsSorting !== null) {
            $params['sorting'] = $channelsSorting->toArray();
        }

        return $this->getEmbeddedPage('/api/channel/my.json', $params);
    }

    /** @param mixed[] $params */
    private function getEmbeddedPage(string $path, array $params) : EmbeddedPage
    {
        $request = $this->createGetRequest($path, $params);

        $response = $this->handleRequest($request);

        $data = $this->decodeResponseBody($response);

        $embedded = \array_map(
            static function ($data) {
                $discriminator         = \key($data);
                $data                  = \reset($data);
                $data['discriminator'] = $discriminator;

                return $data;
            },
            $data['_embedded']['channels']
        );

        $pageInfo = $this->hydrator->hydrateData($data, PageInfo::class);
        $embedded = $this->hydrator->hydrateData($embedded, PrivateChannel::class . '[]');

        return new EmbeddedPage($pageInfo, $embedded);
    }
}
