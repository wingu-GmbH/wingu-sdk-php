<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\Rating;

use Wingu\Engine\SDK\Assertion;

final class Statistic
{
    /** @var string|null */
    private $channel;

    /** @var string|null */
    private $content;

    /** @var string|null */
    private $deck;

    public function __construct(?string $channel = null, ?string $content = null, ?string $deck = null)
    {
        foreach ([$channel, $content, $deck] as $data) {
            if ($data === null) {
                continue;
            }

            Assertion::uuid($data);
        }

        $this->channel = $channel;
        $this->content = $content;
        $this->deck    = $deck;
    }

    /** @return string[] */
    public function toArray() : array
    {
        return \array_filter(
            [
                'channel' => $this->channel,
                'content' => $this->content,
                'deck'    => $this->deck,
            ]
        );
    }
}
