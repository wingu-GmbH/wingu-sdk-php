<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\AudioPlaylist;

use Assert\Assert;
use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\Request;

final class MediaPosition implements Request
{
    /** @var string[] */
    private $orderedMedia;

    /** @param string[] $orderedMedia */
    public function __construct(array $orderedMedia)
    {
        Assertion::notEmpty($orderedMedia);
        Assert::thatAll($orderedMedia)->uuid();

        $this->orderedMedia = $orderedMedia;
    }

    /** @inheritdoc */
    public function jsonSerialize() : array
    {
        return [
            'orderedMedia' => $this->orderedMedia,
        ];
    }
}
