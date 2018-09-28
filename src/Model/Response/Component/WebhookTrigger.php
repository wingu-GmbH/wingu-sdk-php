<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Component;

class WebhookTrigger
{
    /** @var Trigger */
    private $trigger;

    /** @var string */
    private $message;

    public function __construct(Trigger $trigger, string $message)
    {
        $this->trigger = $trigger;
        $this->message = $message;
    }

    public function trigger() : Trigger
    {
        return $this->trigger;
    }

    public function message() : string
    {
        return $this->message;
    }
}
