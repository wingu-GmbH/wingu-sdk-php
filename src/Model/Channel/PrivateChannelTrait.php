<?php

declare(strict_types = 1);

namespace Wingu\Engine\SDK\Model\Channel;

use Speicher210\BusinessHours\BusinessHoursInterface;

trait PrivateChannelTrait
{
    /**
     * @var string|null
     */
    private $note;

    /**
     * The flag if the channel is active.
     *
     * @var bool
     */
    private $active;

    /**
     * The flag if the channel is published.
     *
     * @var bool
     */
    private $published;

    /**
     * The functioning hours of the channel.
     *
     * @var BusinessHoursInterface|null
     */
    private $functioningHours;

    /**
     * @var bool
     */
    private $inFunctioningHours;

    public function note(): ?string
    {
        return $this->note;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function isPublished(): bool
    {
        return $this->published;
    }

    public function functioningHours(): ?BusinessHoursInterface
    {
        return $this->functioningHours;
    }

    public function isInFunctioningHours(): bool
    {
        return $this->inFunctioningHours;
    }
}
