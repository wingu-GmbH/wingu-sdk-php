<?php

declare(strict_types = 1);

namespace Wingu\Engine\SDK\Api\Paginator;

final class Link
{
    private $href;

    public function __construct(string $href)
    {
        $this->href = $href;
    }

    public function href(): string
    {
        return $this->href;
    }
}
