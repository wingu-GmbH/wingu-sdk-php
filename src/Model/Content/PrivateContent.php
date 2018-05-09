<?php

declare(strict_types = 1);

namespace Wingu\Engine\SDK\Model\Content;

use Wingu\Engine\SDK\Assertion;

final class PrivateContent implements Content
{
    private $id;

    private $packs;

    public function __construct(string $id, PackCollection $packs)
    {
        Assertion::uuid($id);

        $this->id = $id;
        $this->packs = $packs;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function packs(): PackCollection
    {
        return $this->packs;
    }
}
