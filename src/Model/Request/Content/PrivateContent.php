<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Content;

use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\Request;

final class PrivateContent implements Request
{
    /** @var string */
    private $template;

    public function __construct(string $template)
    {
        Assertion::uuid($template);
        $this->template = $template;
    }

    /** @inheritdoc */
    public function jsonSerialize() : array
    {
        return [
            'template' => $this->template,
        ];
    }
}
