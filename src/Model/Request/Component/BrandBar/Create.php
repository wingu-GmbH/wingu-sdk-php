<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\BrandBar;

use Wingu\Engine\SDK\Model\Request\Component\BrandBar\Image\Create as Image;
use Wingu\Engine\SDK\Model\Request\Component\BrandBar\Text\Create as Text;
use Wingu\Engine\SDK\Model\Request\MultipartRequest;

final class Create implements MultipartRequest
{
    /** @var Text|null */
    private $text;

    /** @var Image|null */
    private $image;

    /** @var string|null */
    private $backgroundColor;

    public function __construct(?Text $text, ?Image $image, ?string $backgroundColor)
    {
        if ($text === null && $image === null) {
            throw new \InvalidArgumentException('BrandBar requires either Text or Image, or both');
        }

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
