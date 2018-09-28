<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Deck;

use Wingu\Engine\SDK\Model\Request\Request;
use Wingu\Engine\SDK\Model\Request\StringValue;

final class Update implements Request
{
    /** @var string|null */
    private $title;

    /** @var StringValue|null */
    private $description;

    /** @var StringValue|null */
    private $legalNote;

    public function __construct(?string $title = null, ?StringValue $description = null, ?StringValue $legalNote = null)
    {
        $this->title       = $title;
        $this->description = $description;
        $this->legalNote   = $legalNote;
    }

    /** @inheritdoc */
    public function jsonSerialize() : array
    {
        return \array_filter([
            'title' => $this->title,
            'description' => $this->description,
            'legalNote' => $this->legalNote,
        ]);
    }
}
