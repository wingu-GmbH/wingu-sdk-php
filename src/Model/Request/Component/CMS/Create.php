<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\CMS;

use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\Request;

final class Create implements Request
{
    private const TYPES = ['html', 'markdown'];

    /** @var string */
    private $content;

    /** @var string */
    private $type;

    public function __construct(
        string $content,
        string $type
    ) {
        Assertion::inArray($type, self::TYPES);
        $this->content = $content;
        $this->type    = $type;
    }

    /** @inheritdoc */
    public function jsonSerialize() : array
    {
        return [
            'content' => $this->content,
            'type' => $this->type,
        ];
    }
}
