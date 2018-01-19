<?php

declare(strict_types = 1);

namespace Wingu\Engine\SDK\Model\Content;

use Wingu\Engine\SDK\Assertion;

final class PublicContent implements Content
{
    private $id;

    private $category;

    private $pack;

    public function __construct(string $id, Category $category, Pack $pack)
    {
        Assertion::uuid($id);

        $this->id = $id;
        $this->category = $category;
        $this->pack = $pack;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function category(): Category
    {
        return $this->category;
    }

    public function pack(): Pack
    {
        return $this->pack;
    }
}
