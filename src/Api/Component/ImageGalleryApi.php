<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Api\Component;

use Wingu\Engine\SDK\Api\Api;
use Wingu\Engine\SDK\Model\Request\Component\ImageGallery\Create;
use Wingu\Engine\SDK\Model\Response\Component\ImageGallery;

final class ImageGalleryApi extends Api
{
    public function create(Create $imageGallery) : ImageGallery
    {
        $request = $this->createPostRequest('/api/component/image_gallery', $imageGallery);

        $response = $this->handleRequest($request);

        return $this->hydrator->hydrateResponse($response, ImageGallery::class);
    }
}
