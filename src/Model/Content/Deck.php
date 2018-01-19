<?php

declare(strict_types = 1);

namespace Wingu\Engine\SDK\Model\Content;

use Wingu\Engine\SDK\Assertion;

final class Deck
{
    private $id;

    private $title;

    private $description;

    public function __construct(string $id, string $title, ?string $description)
    {
        Assertion::uuid($id);
        Assertion::notEmpty($title);

        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function description(): ?string
    {
        return $this->description;
    }
}
