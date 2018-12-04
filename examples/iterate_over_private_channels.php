<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

$apiKey = 'your-api-key'; // Change this to your API key.

$configuration  = new \Wingu\Engine\SDK\Api\Configuration($apiKey);
$winguApi       = new \Wingu\Engine\SDK\Api\WinguApi($configuration);

$channelsApi = $winguApi->channel();

$channels = $channelsApi->myChannels();

while ($channels->valid()) {
    /** @var \Wingu\Engine\SDK\Model\Response\Channel\PrivateChannel $channel */
    $channel = $channels->current();

    $id = $channel->id();
    $name = $channel->name();

    /** do anything else with PrivateChannel */

    $channels->next();
}
