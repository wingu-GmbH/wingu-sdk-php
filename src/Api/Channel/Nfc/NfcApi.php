<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Api\Channel\Nfc;

use Wingu\Engine\SDK\Api\Api;
use Wingu\Engine\SDK\Api\Paginator\EmbeddedPage;
use Wingu\Engine\SDK\Api\Paginator\PageInfo;
use Wingu\Engine\SDK\Api\Paginator\PaginatedResponseIterator;
use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\Channel\Nfc\PrivateNfc as RequestPrivateNfc;
use Wingu\Engine\SDK\Model\Response\Channel\Nfc\PrivateNfc as PrivateNfcModel;
use Wingu\Engine\SDK\Model\Response\Channel\Nfc\PublicNfc as PublicNfcModel;

final class NfcApi extends Api
{
    public function nfc(string $id) : PublicNfcModel
    {
        $request = $this->createGetRequest('/api/channel/nfc/' . $id . '.json');

        $response = $this->handleRequest($request);

        return $this->hydrator->hydrateResponse($response, PublicNfcModel::class);
    }

    public function myNfc(string $id) : PrivateNfcModel
    {
        $request = $this->createGetRequest('/api/channel/nfc/my/' . $id . '.json');

        $response = $this->handleRequest($request);

        return $this->hydrator->hydrateResponse($response, PrivateNfcModel::class);
    }

    public function payload(string $payload) : string
    {
        $request = $this->createGetRequest('/api/channel/nfc/payload.json', ['payload' => $payload]);

        $response = $this->handleRequest($request);

        $data = $this->decodeResponseBody($response);

        return $data['id'];
    }

    public function myNfcs() : PaginatedResponseIterator
    {
        $page = $this->getEmbeddedPage('/api/channel/nfc/my.json');

        return new PaginatedResponseIterator(
            $page->pageInfo(),
            $page->embedded(),
            function (string $href) {
                return $this->getEmbeddedPage($href);
            }
        );
    }

    public function updateMyNfc(string $id, RequestPrivateNfc $nfc) : void
    {
        Assertion::uuid($id);

        $request = $this->createPatchRequest('/api/channel/nfc/my/' . $id, $nfc);

        $this->handleRequest($request);
    }

    public function deleteMyNfc(string $id) : void
    {
        Assertion::uuid($id);
        $request = $this->createDeleteRequest('/api/channel/nfc/my/' . $id);

        $this->handleRequest($request);
    }

    private function getEmbeddedPage(string $href) : EmbeddedPage
    {
        $request = $this->createGetRequest($href);

        $response = $this->handleRequest($request);

        $data = $this->decodeResponseBody($response);

        $pageInfo = $this->hydrator->hydrateData($data, PageInfo::class);
        $embedded = $this->hydrator->hydrateData(
            \array_column($data['_embedded']['nfcs'], 'nfc'),
            PrivateNfcModel::class . '[]'
        );

        return new EmbeddedPage($pageInfo, $embedded);
    }
}
