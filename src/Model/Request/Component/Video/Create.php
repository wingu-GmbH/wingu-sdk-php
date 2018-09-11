<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\Video;

use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\Request;

final class Create implements Request
{
    private const TYPES = ['vimeo', 'youtube'];

    /** @var string */
    private $type;

    /** @var string */
    private $payload;

    /** @var string|null */
    private $description;

    public function __construct(string $type, string $payload, ?string $description)
    {
        Assertion::inArray($type, self::TYPES);
        $this->type        = $type;
        $this->payload     = $payload;
        $this->description = $description;
    }

    /** @inheritdoc */
    public function jsonSerialize() : array
    {
        return [
            'type' => $this->type,
            'payload' => $this->payload,
            'description' => $this->description,
        ];
    }
}
