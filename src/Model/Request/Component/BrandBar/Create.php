<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\BrandBar;

use Wingu\Engine\SDK\Model\Request\Component\BrandBar\Image\Create as Image;
use Wingu\Engine\SDK\Model\Request\Component\BrandBar\Text\Create as Text;
use Wingu\Engine\SDK\Model\Request\Request;

final class Create implements Request
{
    /** @var Text */
    private $text;

    /** @var Image */
    private $image;

    /** @var string|null */
    private $backgroundColor;

    public function __construct(Text $text, Image $image, ?string $backgroundColor)
    {
        $this->text            = $text;
        $this->image           = $image;
        $this->backgroundColor = $backgroundColor;
    }

    /** @inheritdoc */
    public function jsonSerialize()
    {
        return [
            'text' => $this->text,
            'image' => $this->image,
            'backgroundColor' => $this->backgroundColor,
        ];
    }
}
