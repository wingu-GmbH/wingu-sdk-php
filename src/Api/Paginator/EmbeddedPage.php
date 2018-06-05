<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Api\Paginator;

final class EmbeddedPage
{
    /** @var PageInfo */
    private $pageInfo;

    /** @var mixed */
    private $embedded;

    /** @param mixed $embedded */
    public function __construct(PageInfo $pageInfo, $embedded)
    {
        $this->pageInfo = $pageInfo;
        $this->embedded = $embedded;
    }

    public function pageInfo() : PageInfo
    {
        return $this->pageInfo;
    }

    /** @return mixed */
    public function embedded()
    {
        return $this->embedded;
    }
}
