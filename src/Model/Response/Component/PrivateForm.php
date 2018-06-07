<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Component;

class PrivateForm implements Component
{
    use ComponentTrait;

    /** @var string */
    private $title;

    /** @var string */
    private $feedbackSuccessMessage;

    public function __construct(
        string $id,
        \DateTime $updatedAt,
        string $title,
        string $feedbackSuccessMessage
    ) {
        $this->id                     = $id;
        $this->updatedAt              = $updatedAt;
        $this->title                  = $title;
        $this->feedbackSuccessMessage = $feedbackSuccessMessage;
    }

    public function getTitle() : string
    {
        return $this->title;
    }

    public function getFeedbackSuccessMessage() : string
    {
        return $this->feedbackSuccessMessage;
    }
}
