<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Api\Channel\QrCode;

use Wingu\Engine\SDK\Api\Api;
use Wingu\Engine\SDK\Api\Paginator\EmbeddedPage;
use Wingu\Engine\SDK\Api\Paginator\PageInfo;
use Wingu\Engine\SDK\Api\Paginator\PaginatedResponseIterator;
use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\Channel\QrCode\PrivateQrCode as RequestPrivateQrCode;
use Wingu\Engine\SDK\Model\Response\Channel\QrCode\PrivateQrCode as PrivateQrCodeModel;
use Wingu\Engine\SDK\Model\Response\Channel\QrCode\PublicQrCode as PublicQrCodeModel;

final class QrCodeApi extends Api
{
    public function qrCode(string $id) : PublicQrCodeModel
    {
        $request = $this->createGetRequest('/api/channel/qrcode/' . $id . '.json');

        $response = $this->handleRequest($request);

        return $this->hydrator->hydrateResponse($response, PublicQrCodeModel::class);
    }

    public function myQrCode(string $id) : PrivateQrCodeModel
    {
        $request = $this->createGetRequest('/api/channel/qrcode/my/' . $id . '.json');

        $response = $this->handleRequest($request);

        return $this->hydrator->hydrateResponse($response, PrivateQrCodeModel::class);
    }

    public function payload(string $payload) : string
    {
        $request = $this->createGetRequest('/api/channel/qrcode/payload.json', ['payload' => $payload]);

        $response = $this->handleRequest($request);

        $data = $this->decodeResponseBody($response);

        return $data['id'];
    }

    public function myQrCodes() : PaginatedResponseIterator
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

    public function updateMyQrCode(string $id, RequestPrivateQrCode $qrCode) : void
    {
        Assertion::uuid($id);

        $request = $this->createPatchRequest('/api/channel/qrcode/my/' . $id, $qrCode);

        $this->handleRequest($request);
    }

    public function deleteMyQrCode(string $id) : void
    {
        Assertion::uuid($id);
        $request = $this->createDeleteRequest('/api/channel/qrcode/my/' . $id);

        $this->handleRequest($request);
    }

    private function getEmbeddedPage(string $href) : EmbeddedPage
    {
        $request = $this->createGetRequest($href);

        $response = $this->handleRequest($request);

        $data = $this->decodeResponseBody($response);

        $pageInfo = $this->hydrator->hydrateData($data, PageInfo::class);
        $embedded = $this->hydrator->hydrateData(
            \array_column($data['_embedded']['qrcodes'], 'qrcode'),
            PrivateQrCodeModel::class . '[]'
        );

        return new EmbeddedPage($pageInfo, $embedded);
    }
}
