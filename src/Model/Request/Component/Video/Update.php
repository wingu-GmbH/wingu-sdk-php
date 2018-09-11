<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\Video;

use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\Request;

final class Update implements Request
{
    private const TYPES = ['vimeo', 'youtube'];

    /** @var string|null */
    private $type;

    /** @var string|null */
    private $payload;

    /** @var string|null */
    private $description;

    public function __construct(?string $type, ?string $payload, ?string $description)
    {
        Assertion::inArray($type, self::TYPES);
        $this->type        = $type;
        $this->payload     = $payload;
        $this->description = $description;
    }

    /** @inheritdoc */
    public function jsonSerialize()
    {
        return [
            'type' => $this->type,
            'payload' => $this->payload,
            'description' => $this->description,
        ];
    }
}
