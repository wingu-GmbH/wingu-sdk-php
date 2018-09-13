<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Channel\Beacon;

use Wingu\Engine\SDK\Model\Request\Request;

final class PublicBeaconLocation implements Request
{
    /** @var Coordinates */
    private $coordinates;

    /** @var \DateTimeImmutable */
    private $locationAcquiredDateTime;

    public function __construct(Coordinates $coordinates, \DateTimeImmutable $locationAcquiredDateTime)
    {
        $this->coordinates              = $coordinates;
        $this->locationAcquiredDateTime = $locationAcquiredDateTime;
    }

    /** @inheritdoc */
    public function jsonSerialize() : array
    {
        return [
            'coordinates' => $this->coordinates,
            'locationAcquiredDateTime' => $this->locationAcquiredDateTime->format(\DateTime::ATOM),
        ];
    }
}
