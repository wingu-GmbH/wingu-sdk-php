<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request;

use Wingu\Engine\SDK\Assertion;

final class PaginationParameters implements RequestParameters
{
    /** @var int */
    private $page;

    /** @var int */
    private $limit;

    public function __construct(int $page, int $limit)
    {
        Assertion::greaterThan($page, 0);
        Assertion::greaterThan($limit, 0);
        $this->page  = $page;
        $this->limit = $limit;
    }

    public function page() : int
    {
        return $this->page;
    }

    public function limit() : int
    {
        return $this->limit;
    }

    /** @return mixed[] */
    public function toArray() : array
    {
        return [
            'page' => $this->page,
            'limit' => $this->limit,
        ];
    }
}
