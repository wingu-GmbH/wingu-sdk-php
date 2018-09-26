<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Component;

use Assert\Assertion;

final class Action implements Component
{
    use ComponentTrait;

    /** @var string */
    private $buttonCaption;

    /** @var string */
    private $actionType;

    /** @var string */
    private $actionPayload;

    public function __construct(
        string $id,
        \DateTime $updatedAt,
        string $buttonCaption,
        string $actionType,
        string $actionPayload
    ) {
        Assertion::url($actionPayload);

        $this->id            = $id;
        $this->updatedAt     = $updatedAt;
        $this->buttonCaption = $buttonCaption;
        $this->actionType    = $actionType;
        $this->actionPayload = $actionPayload;
    }

    public function buttonCaption() : string
    {
        return $this->buttonCaption;
    }

    public function actionType() : string
    {
        return $this->actionType;
    }

    public function actionPayload() : string
    {
        return $this->actionPayload;
    }
}
