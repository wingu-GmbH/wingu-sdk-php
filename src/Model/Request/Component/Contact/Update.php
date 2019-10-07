<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\Contact;

use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\Component\Contact\Address\Update as Address;
use Wingu\Engine\SDK\Model\Request\Component\Contact\ExternalLinks\Update as ExternalLinks;
use Wingu\Engine\SDK\Model\Request\Request;
use Wingu\Engine\SDK\Model\Request\StringValue;

final class Update implements Request
{
    /** @var StringValue|null */
    private $companyName;

    /** @var StringValue|null */
    private $personalTitle;

    /** @var StringValue|null */
    private $firstName;

    /** @var StringValue|null */
    private $lastName;

    /** @var StringValue|null */
    private $mobile;

    /** @var StringValue|null */
    private $phone;

    /** @var StringValue|null */
    private $email;

    /** @var StringValue|null */
    private $website;

    /** @var Address|null */
    private $address;

    /** @var StringValue|null */
    private $openingHours;

    /** @var ExternalLinks|null */
    private $externalLinks;

    /** @var StringValue|null */
    private $extraInfo;

    public function __construct(
        ?StringValue $companyName = null,
        ?StringValue $personalTitle = null,
        ?StringValue $firstName = null,
        ?StringValue $lastName = null,
        ?StringValue $mobile = null,
        ?StringValue $phone = null,
        ?StringValue $email = null,
        ?StringValue $website = null,
        ?Address $address = null,
        ?StringValue $openingHours = null,
        ?ExternalLinks $externalLinks = null,
        ?StringValue $extraInfo = null
    ) {
        Assertion::nullOrEmail($email);

        $this->companyName   = $companyName;
        $this->personalTitle = $personalTitle;
        $this->firstName     = $firstName;
        $this->lastName      = $lastName;
        $this->mobile        = $mobile;
        $this->phone         = $phone;
        $this->email         = $email;
        $this->website       = $website;
        $this->address       = $address;
        $this->openingHours  = $openingHours;
        $this->externalLinks = $externalLinks;
        $this->extraInfo     = $extraInfo;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize() : array
    {
        return \array_filter([
            'companyName' => $this->companyName,
            'personalTitle' => $this->personalTitle,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'mobile' => $this->mobile,
            'phone' => $this->phone,
            'email' => $this->email,
            'website' => $this->website,
            'address' => $this->address,
            'openingHours' => $this->openingHours,
            'externalLinks' => $this->externalLinks,
            'extraInfo' => $this->extraInfo,
        ]);
    }
}
