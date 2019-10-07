<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\Form\Resubmit;

use Wingu\Engine\SDK\Model\Request\BooleanValue;
use Wingu\Engine\SDK\Model\Request\Request;

final class Create implements Request
{
    /** @var BooleanValue */
    private $allowed;

    /** @var int|null */
    private $allowedAfterSeconds;

    public function __construct(BooleanValue $allowed, ?int $allowedAfterSeconds)
    {
        $this->allowed             = $allowed;
        $this->allowedAfterSeconds = $allowedAfterSeconds;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize() : array
    {
        return [
            'allowed' => $this->allowed,
            'allowedAfterSeconds' => $this->allowedAfterSeconds,
        ];
    }
}
