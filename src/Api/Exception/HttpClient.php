<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Api\Exception;

use Psr\Http\Message\ResponseInterface;
use Throwable;

class HttpClient extends Generic
{
    /** @var ResponseInterface */
    private $response;

    public function __construct(string $message, ResponseInterface $response, ?Throwable $previous = null)
    {
        $this->response = $response;

        parent::__construct($message, $response->getStatusCode(), $previous);
    }

    public function response() : ResponseInterface
    {
        return $this->response;
    }
}
