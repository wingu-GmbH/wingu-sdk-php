<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Content;

use Wingu\Engine\SDK\Assertion;

final class PrivateContent implements Content
{
    /** @var string */
    private $id;

    /** @var Pack[] */
    private $packs;

    /** @param Pack[] $packs */
    public function __construct(string $id, array $packs)
    {
        Assertion::uuid($id);

        $this->id    = $id;
        $this->packs = $packs;
    }

    public function id() : string
    {
        return $this->id;
    }

    /**
     * @return Pack[]
     */
    public function packs() : array
    {
        return $this->packs;
    }
}
