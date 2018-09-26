<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Component;

use Assert\Assertion;
use Wingu\Engine\SDK\Model\Response\Component\ContactAddress as Address;
use Wingu\Engine\SDK\Model\Response\Component\ContactExternalLinks as ExternalLinks;

final class Contact implements Component
{
    use ComponentTrait;

    /** @var string|null */
    private $companyName;

    /** @var string|null */
    private $personalTitle;

    /** @var string|null */
    private $firstName;

    /** @var string|null */
    private $lastName;

    /** @var string|null */
    private $email;

    /** @var string|null */
    private $mobile;

    /** @var string|null */
    private $phone;

    /** @var string|null */
    private $website;

    /** @var string|null */
    private $openingHours;

    /** @var string|null */
    private $extraInfo;

    /** @var Address|null */
    private $address;

    /** @var ExternalLinks|null */
    private $externalLinks;

    public function __construct(
        string $id,
        \DateTime $updatedAt,
        ?string $companyName,
        ?string $personalTitle,
        ?string $firstName,
        ?string $lastName,
        ?string $email,
        ?string $mobile,
        ?string $phone,
        ?string $website,
        ?string $openingHours,
        ?string $extraInfo,
        ?Address $address,
        ?ExternalLinks $externalLinks
    ) {
        Assertion::nullOrEmail($email);

        $this->id            = $id;
        $this->updatedAt     = $updatedAt;
        $this->companyName   = $companyName;
        $this->personalTitle = $personalTitle;
        $this->firstName     = $firstName;
        $this->lastName      = $lastName;
        $this->email         = $email;
        $this->mobile        = $mobile;
        $this->phone         = $phone;
        $this->website       = $website;
        $this->openingHours  = $openingHours;
        $this->extraInfo     = $extraInfo;
        $this->address       = $address;
        $this->externalLinks = $externalLinks;
    }

    public function companyName() : ?string
    {
        return $this->companyName;
    }

    public function personalTitle() : ?string
    {
        return $this->personalTitle;
    }

    public function firstName() : ?string
    {
        return $this->firstName;
    }

    public function lastName() : ?string
    {
        return $this->lastName;
    }

    public function email() : ?string
    {
        return $this->email;
    }

    public function mobile() : ?string
    {
        return $this->mobile;
    }

    public function phone() : ?string
    {
        return $this->phone;
    }

    public function website() : ?string
    {
        return $this->website;
    }

    public function openingHours() : ?string
    {
        return $this->openingHours;
    }

    public function extraInfo() : ?string
    {
        return $this->extraInfo;
    }

    public function address() : ?Address
    {
        return $this->address;
    }

    public function externalLinks() : ?ExternalLinks
    {
        return $this->externalLinks;
    }
}
