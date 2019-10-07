<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\Contact\ExternalLinks;

use Wingu\Engine\SDK\Model\Request\Request;
use Wingu\Engine\SDK\Model\Request\StringValue;

final class Update implements Request
{
    /** @var StringValue|null */
    private $facebookName;

    /** @var StringValue|null */
    private $twitterName;

    /** @var StringValue|null */
    private $googlePlusName;

    /** @var StringValue|null */
    private $yelpName;

    public function __construct(
        ?StringValue $facebookName = null,
        ?StringValue $twitterName = null,
        ?StringValue $googlePlusName = null,
        ?StringValue $yelpName = null
    ) {
        $this->facebookName   = $facebookName;
        $this->twitterName    = $twitterName;
        $this->googlePlusName = $googlePlusName;
        $this->yelpName       = $yelpName;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize() : array
    {
        return \array_filter([
            'facebookName' => $this->facebookName,
            'twitterName' => $this->twitterName,
            'googlePlusName' => $this->googlePlusName,
            'yelpName' => $this->yelpName,
        ]);
    }
}
