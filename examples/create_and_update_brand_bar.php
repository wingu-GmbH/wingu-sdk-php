<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

$apiKey = '7f094101-5348-4d4e-8356-388c794f5455'; // Change this to your API key.

$configuration = new \Wingu\Engine\SDK\Api\Configuration($apiKey, 'http://wingu');
$winguApi      = new \Wingu\Engine\SDK\Api\WinguApi($configuration);

$imageToUpload = \GuzzleHttp\Psr7\stream_for(\fopen(__DIR__ . '/small_image.jpg', 'rb'));

// Create a new brand bar with the text only.
$brandBar = $winguApi->component()->brandBar()->create(
    new \Wingu\Engine\SDK\Model\Request\Component\BrandBar\Create(
        new \Wingu\Engine\SDK\Model\Request\Component\BrandBar\Text\Create('My brand bar', 'center', '000000'),
        null,
        '0065d3'
    )
);

// Change the text alignment and upload brand bar image.
$winguApi->component()->brandBar()->update(
    $brandBar->id(),
    new \Wingu\Engine\SDK\Model\Request\Component\BrandBar\Update(
        new \Wingu\Engine\SDK\Model\Request\Component\BrandBar\Text\Update(null, 'left', null),
        new \Wingu\Engine\SDK\Model\Request\Component\BrandBar\Image\Update('right', $imageToUpload)
    )
);
