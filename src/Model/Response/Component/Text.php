<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Component;

final class Text implements Component
{
    use ComponentTrait;

    private const TYPE_MARKDOWN = 'markdown';

    private const TYPE_PLAINTEXT = 'plaintext';

    /** @var string */
    private $content;

    /** @var string */
    private $type;

    public function __construct(
        string $id,
        \DateTime $updatedAt,
        string $content,
        string $type
    ) {
        $this->id        = $id;
        $this->updatedAt = $updatedAt;
        $this->content   = $content;
        $this->type      = $type;
    }

    public function content() : string
    {
        return $this->content;
    }

    public function type() : string
    {
        return $this->type;
    }

    public function isMarkdown() : bool
    {
        return $this->type === self::TYPE_MARKDOWN;
    }

    public function isPlaintext() : bool
    {
        return $this->type === self::TYPE_PLAINTEXT;
    }
}
