<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\Html;

use Wingu\Engine\SDK\Model\Request\Request;

final class Create implements Request
{
    /** @var string */
    private $content;

    public function __construct(string $content)
    {
        $this->content = $content;
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize() : array
    {
        return [
            'content' => $this->content,
        ];
    }
}
