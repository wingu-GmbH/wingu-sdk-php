<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

$apiKey = 'your-api-key'; // Change this to your API key.

$configuration  = new \Wingu\Engine\SDK\Api\Configuration($apiKey);

// Explicitly instantiate HTTP client and hydrator
$messageFactory = new \Http\Message\MessageFactory\GuzzleMessageFactory();
$httpClient     = new \Http\Client\Curl\Client($messageFactory);
$hydrator       = new \Wingu\Engine\SDK\Hydrator\SymfonySerializerHydrator();

// Use them to create new instance of Wingu API
$winguApi       = new \Wingu\Engine\SDK\Api\WinguApi($configuration, $httpClient, $messageFactory, $hydrator);

$componentApi = $winguApi->component();

/** @var \Wingu\Engine\SDK\Model\Response\Component\Text $text */
$text = $componentApi->myComponent('98ba7df5-a1f1-49ee-a005-842897b91a1a');

$content = $text->content();

if ($text->isMarkdown()) {
    /** Parse and do other things to Markdown $content you retrieved */
} else {
    /** Content must be plaintext, treat it differently */
}
