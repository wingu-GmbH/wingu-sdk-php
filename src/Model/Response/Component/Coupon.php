<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Component;

class Coupon implements Component
{
    use ComponentTrait;

    /** @var string|null */
    private $header;

    /** @var string */
    private $description;

    /** @var string|null */
    private $disclaimer;

    /** @var CouponBarcode|null */
    private $barcode;

    /** @var Image|null */
    private $backgroundImage;

    public function __construct(
        string $id,
        \DateTime $updatedAt,
        ?string $header,
        string $description,
        ?string $disclaimer,
        ?CouponBarcode $barcode,
        ?Image $backgroundImage
    ) {
        $this->id              = $id;
        $this->updatedAt       = $updatedAt;
        $this->header          = $header;
        $this->description     = $description;
        $this->disclaimer      = $disclaimer;
        $this->barcode         = $barcode;
        $this->backgroundImage = $backgroundImage;
    }

    public function header() : ?string
    {
        return $this->header;
    }

    public function description() : string
    {
        return $this->description;
    }

    public function disclaimer() : ?string
    {
        return $this->disclaimer;
    }

    public function barcode() : ?CouponBarcode
    {
        return $this->barcode;
    }

    public function backgroundImage() : ?Image
    {
        return $this->backgroundImage;
    }
}
