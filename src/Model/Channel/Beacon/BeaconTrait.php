<?php

declare(strict_types = 1);

namespace Wingu\Engine\SDK\Model\Channel\Beacon;

trait BeaconTrait
{
    /**
     * @var string
     */
    private $uuid;

    /**
     * @var int
     */
    private $major;

    /**
     * @var int
     */
    private $minor;

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function major(): int
    {
        return $this->major;
    }

    public function minor(): int
    {
        return $this->minor;
    }
}
