<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Component;

final class ContactExternalLinks
{
    /** @var string */
    private $id;

    /** @var string|null */
    private $facebookUrl;

    /** @var string|null */
    private $twitterUrl;

    /** @var string|null */
    private $googlePlusUrl;

    /** @var string|null */
    private $yelpUrl;

    /** @var string|null */
    private $facebookName;

    /** @var string|null */
    private $twitterName;

    /** @var string|null */
    private $googlePlusName;

    /** @var string|null */
    private $yelpName;

    public function __construct(
        string $id,
        ?string $facebookUrl,
        ?string $twitterUrl,
        ?string $googlePlusUrl,
        ?string $yelpUrl,
        ?string $facebookName,
        ?string $twitterName,
        ?string $googlePlusName,
        ?string $yelpName
    ) {
        $this->id             = $id;
        $this->facebookUrl    = $facebookUrl;
        $this->twitterUrl     = $twitterUrl;
        $this->googlePlusUrl  = $googlePlusUrl;
        $this->yelpUrl        = $yelpUrl;
        $this->facebookName   = $facebookName;
        $this->twitterName    = $twitterName;
        $this->googlePlusName = $googlePlusName;
        $this->yelpName       = $yelpName;
    }

    public function id() : string
    {
        return $this->id;
    }

    public function facebookUrl() : ?string
    {
        return $this->facebookUrl;
    }

    public function twitterUrl() : ?string
    {
        return $this->twitterUrl;
    }

    public function googlePlusUrl() : ?string
    {
        return $this->googlePlusUrl;
    }

    public function yelpUrl() : ?string
    {
        return $this->yelpUrl;
    }

    public function facebookName() : ?string
    {
        return $this->facebookName;
    }

    public function twitterName() : ?string
    {
        return $this->twitterName;
    }

    public function googlePlusName() : ?string
    {
        return $this->googlePlusName;
    }

    public function yelpName() : ?string
    {
        return $this->yelpName;
    }
}
