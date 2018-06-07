<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Content;

use Wingu\Engine\SDK\Assertion;

final class PrivateListContent implements Content
{
    /** @var string */
    private $id;

    /** @var string|null */
    private $title;

    public function __construct(string $id, ?string $title)
    {
        Assertion::uuid($id);

        $this->id    = $id;
        $this->title = $title;
    }

    public function id() : string
    {
        return $this->id;
    }

    public function title() : ?string
    {
        return $this->title;
    }
}
