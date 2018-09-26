<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Api\Component;

use Wingu\Engine\SDK\Api\Api;
use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\Component\ImageGallery\Create;
use Wingu\Engine\SDK\Model\Request\Component\ImageGallery\Image\Create as CreateImageRequest;
use Wingu\Engine\SDK\Model\Request\Component\ImageGallery\Image\Update as UpdateImageRequest;
use Wingu\Engine\SDK\Model\Request\Component\ImageGallery\ImagesPosition;
use Wingu\Engine\SDK\Model\Response\Component\ImageGallery;
use Wingu\Engine\SDK\Model\Response\Component\ImageGalleryImage;

final class ImageGalleryApi extends Api
{
    public function create(Create $imageGallery) : ImageGallery
    {
        $request = $this->createPostRequest('/api/component/image_gallery', $imageGallery);

        $response = $this->handleRequest($request);

        return $this->hydrator->hydrateResponse($response, ImageGallery::class);
    }

    public function createImage(string $id, CreateImageRequest $image) : ImageGalleryImage
    {
        Assertion::uuid($id);
        $request = $this->createMultipartPostRequest('/api/component/image_gallery/' . $id . '/image', $image);

        $response = $this->handleRequest($request);

        return $this->hydrator->hydrateResponse($response, ImageGalleryImage::class);
    }

    public function updateImage(string $id, UpdateImageRequest $image) : void
    {
        Assertion::uuid($id);
        $request = $this->createPatchRequest('/api/component/image_gallery/image/' . $id, $image);

        $this->handleRequest($request);
    }

    public function updateImagesPosition(string $id, ImagesPosition $imagesPosition) : void
    {
        Assertion::uuid($id);
        $request = $this->createPutRequest('/api/component/image_gallery/' . $id . '/images_position', $imagesPosition);

        $this->handleRequest($request);
    }

    public function deleteImage(string $id) : void
    {
        Assertion::uuid($id);
        $request = $this->createDeleteRequest('/api/component/image_gallery/image/' . $id);

        $this->handleRequest($request);
    }
}
