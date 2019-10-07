<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\Contact\Address;

use Wingu\Engine\SDK\Model\Request\Request;
use Wingu\Engine\SDK\Model\Request\StringValue;

final class Update implements Request
{
    /** @var StringValue|null */
    private $country;

    /** @var StringValue|null */
    private $city;

    /** @var StringValue|null */
    private $zipCode;

    /** @var StringValue|null */
    private $street;

    /** @var StringValue|null */
    private $streetNumber;

    public function __construct(
        ?StringValue $country = null,
        ?StringValue $city = null,
        ?StringValue $zipCode = null,
        ?StringValue $street = null,
        ?StringValue $streetNumber = null
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
        return \array_filter([
            'country' => $this->country,
            'city' => $this->city,
            'zipCode' => $this->zipCode,
            'street' => $this->street,
            'streetNumber' => $this->streetNumber,
        ]);
    }
}
