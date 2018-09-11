<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\BrandBar;

use Wingu\Engine\SDK\Model\Request\Component\BrandBar\Image\Update as Image;
use Wingu\Engine\SDK\Model\Request\Component\BrandBar\Text\Update as Text;
use Wingu\Engine\SDK\Model\Request\Request;

final class Update implements Request
{
    /** @var Text|null */
    private $text;

    /** @var Image|null */
    private $image;

    /** @var string|null */
    private $backgroundColor;

    public function __construct(?Text $text, ?Image $image, ?string $backgroundColor)
    {
        $this->text            = $text;
        $this->image           = $image;
        $this->backgroundColor = $backgroundColor;
    }

    /** @inheritdoc */
    public function jsonSerialize() : array
    {
        return [
            'text' => $this->text,
            'image' => $this->image,
            'backgroundColor' => $this->backgroundColor,
        ];
    }
}
