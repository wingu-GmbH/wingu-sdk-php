<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Api\Paginator;

final class Links
{
    /** @var Link */
    private $self;

    /** @var Link */
    private $first;

    /** @var Link */
    private $last;

    /** @var null|Link */
    private $previous;

    /** @var null|Link */
    private $next;

    public function __construct(Link $self, Link $first, Link $last, ?Link $previous = null, ?Link $next = null)
    {
        $this->self     = $self;
        $this->first    = $first;
        $this->last     = $last;
        $this->previous = $previous;
        $this->next     = $next;
    }

    public function self() : Link
    {
        return $this->self;
    }

    public function first() : Link
    {
        return $this->first;
    }

    public function last() : Link
    {
        return $this->last;
    }

    public function previous() : ?Link
    {
        return $this->previous;
    }

    public function next() : ?Link
    {
        return $this->next;
    }
}
