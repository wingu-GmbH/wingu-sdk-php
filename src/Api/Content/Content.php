<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Api\Content;

use Wingu\Engine\SDK\Api\Api;
use Wingu\Engine\SDK\Api\Paginator\EmbeddedPage;
use Wingu\Engine\SDK\Api\Paginator\PageInfo;
use Wingu\Engine\SDK\Api\Paginator\PaginatedResponseIterator;
use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\Content\Pack\Create as CreatePack;
use Wingu\Engine\SDK\Model\Request\Content\Pack\Update as UpdatePack;
use Wingu\Engine\SDK\Model\Request\Content\PrivateContent as RequestContent;
use Wingu\Engine\SDK\Model\Request\Content\PrivateContentChannels;
use Wingu\Engine\SDK\Model\Request\Content\Update as UpdateContent;
use Wingu\Engine\SDK\Model\Response\Content\Pack;
use Wingu\Engine\SDK\Model\Response\Content\PrivateContent;

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

    public function createContent(RequestContent $content) : PrivateContent
    {
        $request = $this->createPostRequest('/api/content', $content);

        $response = $this->handleRequest($request);

        return $this->hydrator->hydrateResponse($response, PrivateContent::class);
    }

    public function createMyPack(CreatePack $pack) : Pack
    {
        $request = $this->createPostRequest('/api/content/my/pack', $pack);

        $response = $this->handleRequest($request);

        return $this->hydrator->hydrateResponse($response, Pack::class);
    }

    public function deleteContent(string $id) : void
    {
        Assertion::uuid($id);
        $request = $this->createDeleteRequest('/api/content/' . $id);

        $this->handleRequest($request);
    }

    public function updateContent(string $id, UpdateContent $content) : void
    {
        Assertion::uuid($id);
        $request = $this->createPatchRequest('/api/content/' . $id, $content);

        $this->handleRequest($request);
    }

    public function deleteMyPack(string $id) : void
    {
        Assertion::uuid($id);
        $request = $this->createDeleteRequest('/api/content/my/pack/' . $id);

        $this->handleRequest($request);
    }

    public function updateMyPack(string $id, UpdatePack $pack) : void
    {
        Assertion::uuid($id);
        $request = $this->createPatchRequest('/api/content/my/pack/' . $id, $pack);

        $this->handleRequest($request);
    }

    public function attachMyContentToChannels(string $id, PrivateContentChannels $content) : void
    {
        Assertion::uuid($id);
        $request = $this->createPatchRequest('/api/content/my/' . $id . '/channels', $content);

        $this->handleRequest($request);
    }

    public function attachMyContentToChannelsExclusively(string $id, PrivateContentChannels $content) : void
    {
        Assertion::uuid($id);
        $request = $this->createPutRequest('/api/content/my/' . $id . '/channels', $content);

        $this->handleRequest($request);
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
