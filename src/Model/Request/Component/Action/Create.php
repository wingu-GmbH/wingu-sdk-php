<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\Action;

use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\Request;

final class Create implements Request
{
    private const TYPES = ['open-url'];

    /** @var string */
    private $buttonCaption;

    /** @var string */
    private $actionType;

    /** @var string */
    private $actionPayload;

    public function __construct(
        string $buttonCaption,
        string $actionType,
        string $actionPayload
    ) {
        Assertion::inArray($actionType, self::TYPES);
        Assertion::url($actionPayload);

        $this->buttonCaption = $buttonCaption;
        $this->actionType    = $actionType;
        $this->actionPayload = $actionPayload;
    }

    /** @inheritdoc */
    public function jsonSerialize() : array
    {
        return [
            'buttonCaption' => $this->buttonCaption,
            'actionType' => $this->actionType,
            'actionPayload' => $this->actionPayload,
        ];
    }
}
