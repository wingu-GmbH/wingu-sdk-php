<?php

declare(strict_types = 1);

namespace Wingu\Engine\SDK\Api\Content;

use Wingu\Engine\SDK\Api\Api;
use Wingu\Engine\SDK\Api\Paginator\PageInfo;
use Wingu\Engine\SDK\Api\Paginator\PaginatedResponseIterator;
use Wingu\Engine\SDK\Model\Content\Category as CategoryModel;

final class Category extends Api
{
    public function categories(): PaginatedResponseIterator
    {
        $page = $this->getEmbeddedPage('/api/category.json');

        return new PaginatedResponseIterator(
            $page['pageInfo'],
            $page['embedded'],
            function (string $href) {
                return $this->getEmbeddedPage($href);
            }
        );
    }

    private function getEmbeddedPage(string $href): array
    {
        $request = $this->createGetRequest($href);

        $response = $this->handleRequest($request);

        $data = $this->decodeResponseBody($response);

        $pageInfo = $this->hydrator->hydrateData($data, PageInfo::class);
        $embedded = $this->hydrator->hydrateData(
            \array_column($data['_embedded']['categories'], 'category'),
            CategoryModel::class . '[]'
        );

        return ['pageInfo' => $pageInfo, 'embedded' => $embedded];
    }
}
