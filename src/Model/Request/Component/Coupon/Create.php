<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\Coupon;

use Wingu\Engine\SDK\Model\Request\Component\Coupon\Barcode\Create as Barcode;
use Wingu\Engine\SDK\Model\Request\Request;

final class Create implements Request
{
    /** @var string */
    private $header;

    /** @var string */
    private $description;

    /** @var Barcode */
    private $barcode;

    /** todo: File
     * private $backgroundImage;
     */

    /** @var string|null */
    private $disclaimer;

    public function __construct(string $header, string $description, Barcode $barcode, ?string $disclaimer)
    {
        $this->header      = $header;
        $this->description = $description;
        $this->barcode     = $barcode;
        $this->disclaimer  = $disclaimer;
    }

    /** @inheritdoc */
    public function jsonSerialize()
    {
        return [
            'header' => $this->header,
            'description' => $this->description,
            'barcode' => $this->barcode,
            'disclaimer' => $this->disclaimer,
        ];
    }
}
