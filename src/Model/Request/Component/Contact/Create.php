<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\Contact;

use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\Component\Contact\Address\Create as Address;
use Wingu\Engine\SDK\Model\Request\Component\Contact\ExternalLinks\Create as ExternalLinks;
use Wingu\Engine\SDK\Model\Request\Request;

final class Create implements Request
{
    /** @var string|null */
    private $companyName;

    /** @var string|null */
    private $personalTitle;

    /** @var string|null */
    private $firstName;

    /** @var string|null */
    private $lastName;

    /** @var string|null */
    private $mobile;

    /** @var string|null */
    private $phone;

    /** @var string|null */
    private $email;

    /** @var string|null */
    private $website;

    /** @var Address */
    private $address;

    /** @var string|null */
    private $openingHours;

    /** @var ExternalLinks */
    private $externalLinks;

    /** @var string|null */
    private $extraInfo;

    public function __construct(
        ?string $companyName,
        ?string $personalTitle,
        ?string $firstName,
        ?string $lastName,
        ?string $mobile,
        ?string $phone,
        ?string $email,
        ?string $website,
        Address $address,
        ?string $openingHours,
        ExternalLinks $externalLinks,
        ?string $extraInfo
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
        return [
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
        ];
    }
}
