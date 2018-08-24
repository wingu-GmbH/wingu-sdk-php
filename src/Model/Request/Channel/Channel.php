<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Channel;

use Wingu\Engine\SDK\Model\Request\BooleanValue;
use Wingu\Engine\SDK\Model\Request\Request;
use Wingu\Engine\SDK\Model\Request\StringValue;

class Channel implements Request
{
    /** @var StringValue|null */
    private $name;

    /** @var StringValue|null */
    private $content;

    /** @var StringValue|null */
    private $note;

    /** @var BooleanValue|null */
    private $published;

    public function __construct(
        ?StringValue $content = null,
        ?StringValue $name = null,
        ?StringValue $note = null,
        ?BooleanValue $published = null
    ) {
        $this->content   = $content;
        $this->name      = $name;
        $this->note      = $note;
        $this->published = $published;
    }

    /** @return mixed[] */
    public function jsonSerialize() : array
    {
        return \array_filter([
            'content'   => $this->content,
            'name'      => $this->name,
            'note'      => $this->note,
            'published' => $this->published,
        ]);
    }
}
