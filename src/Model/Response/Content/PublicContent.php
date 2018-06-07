<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Content;

use Wingu\Engine\SDK\Assertion;

final class PublicContent implements Content
{
    /** @var string */
    private $id;

    /** @var Pack */
    private $pack;

    public function __construct(string $id, Pack $pack)
    {
        Assertion::uuid($id);

        $this->id   = $id;
        $this->pack = $pack;
    }

    public function id() : string
    {
        return $this->id;
    }

    public function pack() : Pack
    {
        return $this->pack;
    }
}
