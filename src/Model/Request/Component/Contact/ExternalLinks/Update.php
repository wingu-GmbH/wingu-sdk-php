<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\Contact\ExternalLinks;

use Wingu\Engine\SDK\Model\Request\Request;

final class Update implements Request
{
    /** @var string|null */
    private $facebookName;

    /** @var string|null */
    private $twitterName;

    /** @var string|null */
    private $googlePlusName;

    /** @var string|null */
    private $yelpName;

    public function __construct(?string $facebookName, ?string $twitterName, ?string $googlePlusName, ?string $yelpName)
    {
        $this->facebookName   = $facebookName;
        $this->twitterName    = $twitterName;
        $this->googlePlusName = $googlePlusName;
        $this->yelpName       = $yelpName;
    }

    /** @inheritdoc */
    public function jsonSerialize() : array
    {
        return [
            'facebookName' => $this->facebookName,
            'twitterName' => $this->twitterName,
            'googlePlusName' => $this->googlePlusName,
            'yelpName' => $this->yelpName,
        ];
    }
}
