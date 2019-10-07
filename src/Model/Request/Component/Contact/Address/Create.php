<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\Contact\Address;

use Wingu\Engine\SDK\Model\Request\Request;

final class Create implements Request
{
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
        ?string $country,
        ?string $city,
        ?string $zipCode,
        ?string $street,
        ?string $streetNumber
    ) {
        $this->country      = $country;
        $this->city         = $city;
        $this->zipCode      = $zipCode;
        $this->street       = $street;
        $this->streetNumber = $streetNumber;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize() : array
    {
        return [
            'country' => $this->country,
            'city' => $this->city,
            'zipCode' => $this->zipCode,
            'street' => $this->street,
            'streetNumber' => $this->streetNumber,
        ];
    }
}
