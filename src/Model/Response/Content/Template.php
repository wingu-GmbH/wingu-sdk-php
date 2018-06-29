<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Content;

use Wingu\Engine\SDK\Assertion;

final class Template
{
    /** @var string */
    private $id;

    /** @var string */
    private $background;

    /** @var string */
    private $fontColor;

    /** @var string */
    private $fontType;

    public function __construct(string $id, string $background, string $fontColor, string $fontType)
    {
        Assertion::uuid($id);
        $this->id         = $id;
        $this->background = $background;
        $this->fontColor  = $fontColor;
        $this->fontType   = $fontType;
    }

    public function id() : string
    {
        return $this->id;
    }

    public function background() : string
    {
        return $this->background;
    }

    public function fontColor() : string
    {
        return $this->fontColor;
    }

    public function fontType() : string
    {
        return $this->fontType;
    }
}
