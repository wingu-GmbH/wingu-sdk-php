<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Component;

class PrivateWebhook implements Component
{
    use ComponentTrait;

    /** @var string */
    private $buttonCaption;

    /** @var string */
    private $url;

    /** @var string */
    private $feedbackSuccessMessage;

    public function __construct(
        string $id,
        \DateTime $updatedAt,
        string $buttonCaption,
        string $url,
        string $feedbackSuccessMessage
    ) {
        $this->id                     = $id;
        $this->updatedAt              = $updatedAt;
        $this->buttonCaption          = $buttonCaption;
        $this->url                    = $url;
        $this->feedbackSuccessMessage = $feedbackSuccessMessage;
    }

    public function buttonCaption() : string
    {
        return $this->buttonCaption;
    }

    public function url() : string
    {
        return $this->url;
    }

    public function feedbackSuccessMessage() : string
    {
        return $this->feedbackSuccessMessage;
    }
}
