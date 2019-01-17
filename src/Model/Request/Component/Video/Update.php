<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\Video;

use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\Request;
use Wingu\Engine\SDK\Model\Request\StringValue;

final class Update implements Request
{
    private const TYPES = ['youtube'];

    /** @var string|null */
    private $type;

    /** @var string|null */
    private $payload;

    /** @var StringValue|null */
    private $description;

    public function __construct(?string $type = null, ?string $payload = null, ?StringValue $description = null)
    {
        Assertion::nullOrInArray($type, self::TYPES);

        $this->type        = $type;
        $this->payload     = $payload;
        $this->description = $description;
    }

    /** @inheritdoc */
    public function jsonSerialize() : array
    {
        return \array_filter([
            'type' => $this->type,
            'payload' => $this->payload,
            'description' => $this->description,
        ]);
    }
}
