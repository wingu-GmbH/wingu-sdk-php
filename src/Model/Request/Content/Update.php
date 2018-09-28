<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Content;

use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\Request;

final class Update implements Request
{
    /** @var string|null */
    private $template;

    public function __construct(?string $template = null)
    {
        if ($template !== null) {
            Assertion::uuid($template);
        }

        $this->template = $template;
    }

    /** @inheritdoc */
    public function jsonSerialize() : array
    {
        return \array_filter([
            'template' => $this->template,
        ]);
    }
}
