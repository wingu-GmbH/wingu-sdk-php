<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\Rating;

use Wingu\Engine\SDK\Model\Request\Request;

final class Create implements Request
{
    /** @var string */
    private $title;

    public function __construct(string $title)
    {
        $this->title = $title;
    }

    /** @inheritdoc */
    public function jsonSerialize() : array
    {
        return [
            'title' => $this->title,
        ];
    }
}
