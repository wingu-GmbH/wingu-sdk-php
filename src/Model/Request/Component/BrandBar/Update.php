<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\BrandBar;

use Wingu\Engine\SDK\Model\Request\Component\BrandBar\Image\Update as Image;
use Wingu\Engine\SDK\Model\Request\Component\BrandBar\Text\Update as Text;
use Wingu\Engine\SDK\Model\Request\MultipartRequest;
use Wingu\Engine\SDK\Model\Request\StringValue;

final class Update implements MultipartRequest
{
    /** @var Text|null */
    private $text;

    /** @var Image|null */
    private $image;

    /** @var StringValue|null */
    private $backgroundColor;

    public function __construct(?Text $text = null, ?Image $image = null, ?StringValue $backgroundColor = null)
    {
        $this->text            = $text;
        $this->image           = $image;
        $this->backgroundColor = $backgroundColor;
    }

    /** @inheritdoc */
    public function jsonSerialize() : array
    {
        return \array_filter([
            'text' => $this->text,
            'image' => $this->image,
            'backgroundColor' => $this->backgroundColor,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function files() : array
    {
        if ($this->image !== null) {
            return [
                'image' => $this->image->files(),
            ];
        }

        return [];
    }
}
