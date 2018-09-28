<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\Action;

use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\Request;

final class Update implements Request
{
    private const TYPES = ['open-url'];

    /** @var string|null */
    private $buttonCaption;

    /** @var string|null */
    private $actionType;

    /** @var string|null */
    private $actionPayload;

    public function __construct(
        ?string $buttonCaption = null,
        ?string $actionType = null,
        ?string $actionPayload = null
    ) {
        Assertion::nullOrInArray($actionType, self::TYPES);
        Assertion::nullOrUrl($actionPayload);

        $this->buttonCaption = $buttonCaption;
        $this->actionType    = $actionType;
        $this->actionPayload = $actionPayload;
    }

    /** @inheritdoc */
    public function jsonSerialize() : array
    {
        return \array_filter([
            'buttonCaption' => $this->buttonCaption,
            'actionType' => $this->actionType,
            'actionPayload' => $this->actionPayload,
        ]);
    }
}
