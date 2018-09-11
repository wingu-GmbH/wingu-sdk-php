<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Deck;

use Wingu\Engine\SDK\Model\Request\Request;

final class Deck implements Request
{
    /** @var string */
    private $title;

    /** @var string|null */
    private $description;

    /** @var string|null */
    private $legalNote;

    public function __construct(string $title, ?string $description, ?string $legalNote)
    {
        $this->title       = $title;
        $this->description = $description;
        $this->legalNote   = $legalNote;
    }

    /** @inheritdoc */
    public function jsonSerialize() : array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'legalNote' => $this->legalNote,
        ];
    }
}
