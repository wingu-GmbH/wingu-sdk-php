<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Component;

final class ContactAddress
{
    /** @var string */
    private $id;

    /** @var string|null */
    private $country;

    /** @var string|null */
    private $city;

    /** @var string|null */
    private $zipCode;

    /** @var string|null */
    private $street;

    /** @var string|null */
    private $streetNumber;

    public function __construct(
        string $id,
        ?string $country,
        ?string $city,
        ?string $zipCode,
        ?string $street,
        ?string $streetNumber
    ) {
        $this->id           = $id;
        $this->country      = $country;
        $this->city         = $city;
        $this->zipCode      = $zipCode;
        $this->street       = $street;
        $this->streetNumber = $streetNumber;
    }

    public function id() : string
    {
        return $this->id;
    }

    public function country() : ?string
    {
        return $this->country;
    }

    public function city() : ?string
    {
        return $this->city;
    }

    public function zipCode() : ?string
    {
        return $this->zipCode;
    }

    public function street() : ?string
    {
        return $this->street;
    }

    public function streetNumber() : ?string
    {
        return $this->streetNumber;
    }
}
