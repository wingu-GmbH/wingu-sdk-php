<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\Coupon;

use Psr\Http\Message\StreamInterface;
use Wingu\Engine\SDK\Model\Request\Component\Coupon\Barcode\Update as Barcode;
use Wingu\Engine\SDK\Model\Request\MultipartRequest;
use Wingu\Engine\SDK\Model\Request\StringValue;

final class Update implements MultipartRequest
{
    /** @var StringValue|null */
    private $header;

    /** @var string|null */
    private $description;

    /** @var Barcode|null */
    private $barcode;

    /** @var StreamInterface|null */
    private $backgroundImage;

    /** @var StringValue|null */
    private $disclaimer;

    public function __construct(
        ?StringValue $header = null,
        ?string $description = null,
        ?Barcode $barcode = null,
        ?StreamInterface $backgroundImage = null,
        ?StringValue $disclaimer = null
    ) {
        $this->header          = $header;
        $this->description     = $description;
        $this->barcode         = $barcode;
        $this->backgroundImage = $backgroundImage;
        $this->disclaimer      = $disclaimer;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize() : array
    {
        return \array_filter([
            'header' => $this->header,
            'description' => $this->description,
            'barcode' => $this->barcode,
            'disclaimer' => $this->disclaimer,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function files() : array
    {
        if ($this->backgroundImage === null) {
            return [];
        }

        return [
            'backgroundImage' => $this->backgroundImage,
        ];
    }
}
