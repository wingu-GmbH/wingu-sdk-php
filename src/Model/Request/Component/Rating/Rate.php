<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\Rating;

use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\Request;

final class Rate implements Request
{
    private const MIN_VALUE = 1;
    private const MAX_VALUE = 5;

    /** @var string|null */
    private $channel;

    /** @var string */
    private $content;

    /** @var string */
    private $deck;

    /** @var int */
    private $value;

    /** @var string */
    private $rating;

    public function __construct(?string $channel, string $content, string $deck, int $value, string $rating)
    {
        Assertion::range($value, self::MIN_VALUE, self::MAX_VALUE);
        $this->channel = $channel;
        $this->content = $content;
        $this->deck    = $deck;
        $this->value   = $value;
        $this->rating  = $rating;
    }

    /** @inheritdoc */
    public function jsonSerialize() : array
    {
        return [
            'channel' => $this->channel,
            'content' => $this->content,
            'deck' => $this->deck,
            'value' => $this->value,
            'rating' => $this->rating,
        ];
    }
}
