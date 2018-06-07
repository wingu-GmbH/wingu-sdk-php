<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Component;

class PublicWebhook implements Component
{
    use ComponentTrait;

    /** @var string */
    private $buttonCaption;

    public function __construct(
        string $id,
        \DateTime $updatedAt,
        string $buttonCaption
    ) {
        $this->id            = $id;
        $this->updatedAt     = $updatedAt;
        $this->buttonCaption = $buttonCaption;
    }

    public function buttonCaption() : string
    {
        return $this->buttonCaption;
    }
}
