<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Wingu\Ping;

use Wingu\Engine\SDK\Assertion;

final class Cloudinary
{
    /** @var string */
    private $cloudName;

    public function __construct(string $cloudName)
    {
        Assertion::notEmpty($cloudName);

        $this->cloudName = $cloudName;
    }

    public function cloudName() : string
    {
        return $this->cloudName;
    }
}
