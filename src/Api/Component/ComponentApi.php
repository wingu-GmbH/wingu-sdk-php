<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Api\Component;

use Wingu\Engine\SDK\Api\Api;
use Wingu\Engine\SDK\Api\Paginator\EmbeddedPage;
use Wingu\Engine\SDK\Api\Paginator\PageInfo;
use Wingu\Engine\SDK\Api\Paginator\PaginatedResponseIterator;
use Wingu\Engine\SDK\Model\Component\Component;

final class ComponentApi extends Api
{
    public function myComponent(string $id) : Component
    {
        $request = $this->createGetRequest('/api/component/' . $id . '.json');

        $response = $this->handleRequest($request);

        return $this->hydrator->hydrateResponse($response, Component::class);
    }

    public function myComponents() : PaginatedResponseIterator
    {
        $page = $this->getEmbeddedPage('/api/component/my.json');

        return new PaginatedResponseIterator(
            $page->pageInfo(),
            $page->embedded(),
            function () {
                return $this->getEmbeddedPage('/api/component/my.json');
            }
        );
    }

    private function getEmbeddedPage(string $path) : EmbeddedPage
    {
        $request = $this->createGetRequest($path);

        $response = $this->handleRequest($request);

        $data = $this->decodeResponseBody($response);

        $embedded = \array_map(
            function ($data) {
                $discriminator         = $data['component']['discriminator'];
                $data                  = \reset($data);
                $data['discriminator'] = $discriminator;

                return $data;
            },
            $data['_embedded']['components']
        );

        $pageInfo = $this->hydrator->hydrateData($data, PageInfo::class);
        $embedded = $this->hydrator->hydrateData(
            $embedded,
            Component::class . '[]'
        );

        return new EmbeddedPage($pageInfo, $embedded);
    }
}
