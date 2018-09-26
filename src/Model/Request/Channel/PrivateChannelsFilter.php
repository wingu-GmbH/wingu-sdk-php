<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Channel;

use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\RequestParameters;

final class PrivateChannelsFilter implements RequestParameters
{
    private const DISCRIMINATORS = ['beacon', 'geofence', 'nfc', 'qrcode'];

    /** @var string[]|null */
    private $channels;

    /** @var string|null */
    private $name;

    /** @var string|null */
    private $discriminator;

    /** @var bool|null */
    private $published;

    /** @var bool|null */
    private $inFunctioningHours;

    /** @var string|null */
    private $content;

    /** @var bool|null */
    private $hasContentAttached;

    /**
     * @param string[] $channels
     */
    public function __construct(
        ?array $channels = null,
        ?string $name = null,
        ?string $discriminator = null,
        ?bool $published = null,
        ?bool $inFunctioningHours = null,
        ?string $content = null,
        ?bool $hasContentAttached = null
    ) {
        if ($channels !== null) {
            foreach ($channels as $channel) {
                Assertion::uuid($channel);
            }
        }
        Assertion::nullOrInArray($discriminator, self::DISCRIMINATORS);

        $this->channels           = $channels;
        $this->name               = $name;
        $this->discriminator      = $discriminator;
        $this->published          = $published;
        $this->inFunctioningHours = $inFunctioningHours;
        $this->content            = $content;
        $this->hasContentAttached = $hasContentAttached;
    }

    /** @return mixed[] */
    public function toArray() : array
    {
        return \array_filter([
            'channels' => $this->channels,
            'name' => $this->name,
            'discriminator' => $this->discriminator,
            'published' => $this->checkBooleanKey($this->published),
            'inFunctioningHours' => $this->checkBooleanKey($this->inFunctioningHours),
            'content' => $this->content,
            'hasContentAttached' => $this->checkBooleanKey($this->hasContentAttached),
        ]);
    }

    private function checkBooleanKey(?bool $key) : ?string
    {
        if ($key === true) {
            return '1';
        }
        if ($key === false) {
            return '0';
        }
        return null;
    }
}
