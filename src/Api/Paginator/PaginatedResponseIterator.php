<?php

declare(strict_types = 1);

namespace Wingu\Engine\SDK\Api\Paginator;

final class PaginatedResponseIterator implements \Iterator, \Countable
{
    private $currentPagePosition;

    private $pageInfo;

    private $embedded;

    private $dataFetcher;

    public function __construct(PageInfo $pageInfo, $embedded, callable $dataFetcher)
    {
        $this->currentPagePosition = 0;

        $this->pageInfo = $pageInfo;
        $this->embedded = \array_values($embedded);

        $this->dataFetcher = $dataFetcher;
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        return $this->embedded[$this->currentPagePosition];
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        $this->currentPagePosition++;

        if ($this->currentPagePosition === $this->pageInfo->limit() && $this->pageInfo->hasNextPage()) {
            $this->fetchEmbedded($this->pageInfo->links()->next());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return $this->currentPagePosition + ($this->pageInfo->limit() * ($this->pageInfo->page() - 1));
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return isset($this->embedded[$this->currentPagePosition]);
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        $this->currentPagePosition = 0;
        if ($this->pageInfo->page() !== 1) {
            $this->fetchEmbedded($this->pageInfo->links()->first());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return $this->pageInfo->total();
    }

    private function fetchEmbedded(Link $link)
    {
        $data = \call_user_func($this->dataFetcher, $link->href());
        $this->pageInfo = $data['pageInfo'];
        $this->embedded = $data['embedded'];
        $this->currentPagePosition = 0;
    }
}
