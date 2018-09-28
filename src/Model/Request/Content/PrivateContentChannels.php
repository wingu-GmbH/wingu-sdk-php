<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Content;

use Assert\Assert;
use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\Request;

final class PrivateContentChannels implements Request
{
    /** @var string[] */
    private $channels;

    /** @param string[] $channels */
    public function __construct(array $channels)
    {
        Assertion::notEmpty($channels);
        Assert::thatAll($channels)->uuid();

        $this->channels = $channels;
    }

    /** @inheritdoc */
    public function jsonSerialize() : array
    {
        return [
            'channels' => $this->channels,
        ];
    }
}
