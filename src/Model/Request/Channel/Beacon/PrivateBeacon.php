<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Channel\Beacon;

use Wingu\Engine\SDK\Model\Request\BooleanValue;
use Wingu\Engine\SDK\Model\Request\Channel\Channel;
use Wingu\Engine\SDK\Model\Request\StringValue;

final class PrivateBeacon extends Channel
{
    /** @var BeaconLocation */
    private $location;

    public function __construct(
        BeaconLocation $location,
        ?StringValue $content = null,
        ?StringValue $name = null,
        ?StringValue $note = null,
        ?BooleanValue $published = null
    ) {
        parent::__construct($content, $name, $note, $published);
        $this->location = $location;
    }

    /** @inheritdoc */
    public function jsonSerialize() : array
    {
        return \array_merge(
            parent::jsonSerialize(),
            [
                'location' => $this->location,
            ]
        );
    }
}
