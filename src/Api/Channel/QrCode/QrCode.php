<?php

declare(strict_types = 1);

namespace Wingu\Engine\SDK\Api\Channel\QrCode;

use Wingu\Engine\SDK\Api\Api;
use Wingu\Engine\SDK\Model\Channel\QrCode\PrivateQrCode as PrivateQrCodeModel;
use Wingu\Engine\SDK\Model\Channel\QrCode\PublicQrCode as PublicQrCodeModel;

final class QrCode extends Api
{
    public function qrCode(string $id): PublicQrCodeModel
    {
        $request = $this->createGetRequest('/api/channel/qrcode/' . $id . '.json');

        $response = $this->handleRequest($request);

        return $this->hydrator->hydrateResponse($response, PublicQrCodeModel::class);
    }

    public function myQrCode(string $id): PrivateQrCodeModel
    {
        $request = $this->createGetRequest('/api/channel/qrcode/my/' . $id . '.json');

        $response = $this->handleRequest($request);

        return $this->hydrator->hydrateResponse($response, PrivateQrCodeModel::class);
    }

    public function payload(string $payload): string
    {
        $request = $this->createGetRequest('/api/channel/qrcode/payload.json', ['payload' => $payload]);

        $response = $this->handleRequest($request);

        $data = $this->decodeResponseBody($response);

        return $data['id'];
    }
}