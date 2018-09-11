<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Api\Paginator;

final class PaginatedResponseIterator implements \Iterator, \Countable
{
    /** @var int */
    private $currentPagePosition;

    /** @var PageInfo */
    private $pageInfo;

    /** @var mixed[] */
    private $embedded;

    /** @var callable */
    private $dataFetcher;

    /** @param mixed[] $embedded */
    public function __construct(PageInfo $pageInfo, array $embedded, callable $dataFetcher)
    {
        $this->currentPagePosition = 0;

        $this->pageInfo = $pageInfo;
        $this->embedded = \array_values($embedded);

        $this->dataFetcher = $dataFetcher;
    }

    /**
     * @return mixed
     */
    public function current()
    {
        return $this->embedded[$this->currentPagePosition];
    }

    /**
     * {@inheritdoc}
     */
    public function next() : void
    {
        $this->currentPagePosition++;

        if ($this->currentPagePosition !== $this->pageInfo->limit() || $this->pageInfo->links()->next() === null) {
            return;
        }

        $this->fetchEmbedded($this->pageInfo->links()->next());
    }

    /**
     * @return mixed
     */
    public function key()
    {
        return $this->currentPagePosition + ($this->pageInfo->limit() * ($this->pageInfo->page() - 1));
    }

    /**
     * {@inheritdoc}
     */
    public function valid() : bool
    {
        return isset($this->embedded[$this->currentPagePosition]);
    }

    /**
     * {@inheritdoc}
     */
    public function rewind() : void
    {
        $this->currentPagePosition = 0;
        if ($this->pageInfo->page() === 1) {
            return;
        }

        $this->fetchEmbedded($this->pageInfo->links()->first());
    }


//    public function seek($position) {
//        if (!isset($this->array[$position])) {
//            throw new OutOfBoundsException("invalid seek position ($position)");
//        }
//
//        $this->position = $position;
//    }

//    /**
//     * {@inheritdoc}
//     */
//    public function seek($position)
//    {
//        $this->currentPagePosition = $position;
//        if (! $this->valid()) {
//            throw new \OutOfBoundsException();
//        }
//        $this->fetchEmbedded($this->pageInfo->links->self());
//    }

    /**
     * {@inheritdoc}
     */
    public function count() : int
    {
        return $this->pageInfo->total();
    }

    private function fetchEmbedded(Link $link) : void
    {
        /** @var EmbeddedPage $data */
        $data                      = \call_user_func($this->dataFetcher, $link->href());
        $this->pageInfo            = $data->pageInfo();
        $this->embedded            = $data->embedded();
        $this->currentPagePosition = 0;
    }
}
