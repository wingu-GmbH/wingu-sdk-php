<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

$apiKey = 'your-api-key'; // Change this to your API key.

$configuration = new \Wingu\Engine\SDK\Api\Configuration($apiKey);
$winguApi      = new \Wingu\Engine\SDK\Api\WinguApi($configuration);

/** @var \Wingu\Engine\SDK\Model\Response\Component\Component $component */
foreach ($winguApi->component()->myComponents() as $component) {
    echo $component->id() . PHP_EOL;
}
