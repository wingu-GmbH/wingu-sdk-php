<?php

declare(strict_types = 1);

namespace Wingu\Engine\SDK\Api\Paginator;

final class PageInfo
{
    private $page;

    private $limit;

    private $pages;

    private $total;

    private $links;

    public function __construct(int $page, int $limit, int $pages, int $total, Links $_links)
    {
        $this->page = $page;
        $this->limit = $limit;
        $this->pages = $pages;
        $this->total = $total;
        $this->links = $_links;
    }

    public function page(): int
    {
        return $this->page;
    }

    public function limit(): int
    {
        return $this->limit;
    }

    public function pages(): int
    {
        return $this->pages;
    }

    public function total(): int
    {
        return $this->total;
    }

    public function links(): Links
    {
        return $this->links;
    }

    public function hasNextPage(): bool
    {
        return $this->links->next() !== null;
    }
}
