<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

$apiKey = 'your-api-key'; // Change this to your API key.

$configuration  = new \Wingu\Engine\SDK\Api\Configuration($apiKey);
$winguApi       = new \Wingu\Engine\SDK\Api\WinguApi($configuration);

$componentApi = $winguApi->component();

// Create a new image gallery component.
$imageGallery = $componentApi->imageGallery()->create(new \Wingu\Engine\SDK\Model\Request\Component\ImageGallery\Create());

// Create a stream for an image to upload.
$imageToUpload = \GuzzleHttp\Psr7\stream_for(\fopen(__DIR__ . '/wingu_image.png', 'rb'));

// Add a new image to the image gallery.
$componentApi->imageGallery()->createImage(
    $imageGallery->id(),
    new \Wingu\Engine\SDK\Model\Request\Component\ImageGallery\Image\Create($imageToUpload, 'very nice image')
);

// Get back the image gallery with the image added.
$imageGalleryWithImage = $componentApi->myComponent($imageGallery->id());

echo $imageGalleryWithImage->id();
