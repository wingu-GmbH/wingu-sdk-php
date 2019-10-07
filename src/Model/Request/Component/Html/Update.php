<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\Html;

use Wingu\Engine\SDK\Model\Request\Request;

final class Update implements Request
{
    /** @var string|null */
    private $content;

    public function __construct(?string $content = null)
    {
        $this->content = $content;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize() : array
    {
        return \array_filter([
            'content' => $this->content,
        ]);
    }
}
