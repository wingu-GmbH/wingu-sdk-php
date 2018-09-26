<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Component\SubmitDestination;

use Wingu\Engine\SDK\Assertion;

final class Endpoint implements SubmitDestination
{
    /** @var string */
    private $url;

    /** @var EndpointHeader[] */
    private $headers;

    /** @param EndpointHeader[] $headers */
    public function __construct(string $url, array $headers)
    {
        Assertion::url($url);
        Assertion::allIsInstanceOf($headers, EndpointHeader::class);

        $this->url     = $url;
        $this->headers = $headers;
    }

    public function url() : string
    {
        return $this->url;
    }

    /** @return EndpointHeader[] */
    public function headers() : array
    {
        return $this->headers;
    }
}
