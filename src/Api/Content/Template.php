<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Api\Content;

use Wingu\Engine\SDK\Api\Api;
use Wingu\Engine\SDK\Api\Paginator\EmbeddedPage;
use Wingu\Engine\SDK\Api\Paginator\PageInfo;
use Wingu\Engine\SDK\Api\Paginator\PaginatedResponseIterator;
use Wingu\Engine\SDK\Model\Response\Content\Template as TemplateModel;

final class Template extends Api
{
    public function templates() : PaginatedResponseIterator
    {
        $page = $this->getEmbeddedPage('/api/template');

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
            \array_column($data['_embedded']['templates'], 'template'),
            TemplateModel::class . '[]'
        );

        return new EmbeddedPage($pageInfo, $embedded);
    }
}
