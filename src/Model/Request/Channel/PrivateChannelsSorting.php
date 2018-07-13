<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Channel;

use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\RequestParameters;

class PrivateChannelsSorting implements RequestParameters
{
    /** @var string|null */
    private $id;

    /** @var string|null */
    private $name;

    /** @var string|null */
    private $createdAt;

    public function __construct(?string $id = null, ?string $name = null, ?string $createdAt = null)
    {
        Assertion::nullOrInArray($id, RequestParameters::SORTING_ORDER);
        Assertion::nullOrInArray($name, RequestParameters::SORTING_ORDER);
        Assertion::nullOrInArray($createdAt, RequestParameters::SORTING_ORDER);
        $this->id        = $id;
        $this->name      = $name;
        $this->createdAt = $createdAt;
    }

    /** @return mixed[] */
    public function toArray() : array
    {
        return \array_filter([
            'id' => $this->id,
            'name' => $this->name,
            'createdAt' => $this->createdAt,
        ]);
    }
}
