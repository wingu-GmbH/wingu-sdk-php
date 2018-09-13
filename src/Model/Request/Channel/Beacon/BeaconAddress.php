<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Channel\Beacon;

use Wingu\Engine\SDK\Model\Request\Request;

final class BeaconAddress implements Request
{
    /** @var string */
    private $formattedAddress;

    public function __construct(string $formattedAddress)
    {
        $this->formattedAddress = $formattedAddress;
    }

    /** @inheritdoc */
    public function jsonSerialize() : array
    {
        return [
            'formattedAddress' => $this->formattedAddress,
        ];
    }
}
