<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

$apiKey = 'your-api-key'; // Change this to your API key.

$configuration  = new \Wingu\Engine\SDK\Api\Configuration($apiKey);
$winguApi       = new \Wingu\Engine\SDK\Api\WinguApi($configuration);

// Create new CMS component with your content, it can also be Markdown, if so - pass 'markdown' as 2nd parameter
$createdComponent = $winguApi->component()->cms()->create(new \Wingu\Engine\SDK\Model\Request\Component\CMS\Create('<p>html content</p>', 'html'));

// Create new Deck that will later on hold CMS component, optionally you can add description and legal note to it
$createdDeck      = $winguApi->deck()->createDeck(new \Wingu\Engine\SDK\Model\Request\Deck\Create('Deck title', 'Short description', 'Some legal note'));

// Fetch first available template and store its ID
$template         = $winguApi->contentTemplate()->templates()->current()->id();

// Use template above to create new Content
$createdContent   = $winguApi->content()->createContent(new \Wingu\Engine\SDK\Model\Request\Content\PrivateContent($template));

// Attach CMS Component to Deck you created before
$winguApi->card()->addCardToDeck(new \Wingu\Engine\SDK\Model\Request\Card($createdDeck->id(), $createdComponent->id(), 0));

// Create new Content Pack, english in this case
$winguApi->content()->createMyPack(new Wingu\Engine\SDK\Model\Request\Content\Pack\Create($createdContent->id(), $createdDeck->id(),'en'));

// Link created Content to Wingu Triggers aka Channels
$winguApi->content()->attachMyContentToChannels($createdContent->id(), new \Wingu\Engine\SDK\Model\Request\Content\PrivateContentChannels($_POST['wingu_channels_ids']));
