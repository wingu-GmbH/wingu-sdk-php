<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Api\Content;

use Wingu\Engine\SDK\Api\Api;
use Wingu\Engine\SDK\Api\Paginator\EmbeddedPage;
use Wingu\Engine\SDK\Api\Paginator\PageInfo;
use Wingu\Engine\SDK\Api\Paginator\PaginatedResponseIterator;
use Wingu\Engine\SDK\Model\Content\PrivateContent;

final class Content extends Api
{
    public function myContent(string $id) : PrivateContent
    {
        $request = $this->createGetRequest('/api/content/my/' . $id . '.json');

        $response = $this->handleRequest($request);

        return $this->hydrator->hydrateResponse($response, PrivateContent::class);
    }

    public function myContents() : PaginatedResponseIterator
    {
        $page = $this->getEmbeddedPage('/api/content/my.json');

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
            \array_column($data['_embedded']['contents'], 'content'),
            PrivateContent::class . '[]'
        );

        return new EmbeddedPage($pageInfo, $embedded);
    }
}
