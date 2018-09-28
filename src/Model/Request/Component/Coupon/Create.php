<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\Coupon;

use Psr\Http\Message\StreamInterface;
use Wingu\Engine\SDK\Model\Request\Component\Coupon\Barcode\Create as Barcode;
use Wingu\Engine\SDK\Model\Request\MultipartRequest;

final class Create implements MultipartRequest
{
    /** @var string|null */
    private $header;

    /** @var string */
    private $description;

    /** @var Barcode|null */
    private $barcode;

    /** @var StreamInterface|null */
    private $backgroundImage;

    /** @var string|null */
    private $disclaimer;

    public function __construct(
        ?string $header,
        string $description,
        ?Barcode $barcode,
        ?StreamInterface $backgroundImage,
        ?string $disclaimer
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
        return [
            'header' => $this->header,
            'description' => $this->description,
            'barcode' => $this->barcode,
            'disclaimer' => $this->disclaimer,
        ];
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
