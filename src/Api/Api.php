<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Api;

use Http\Client\HttpClient;
use Http\Message\RequestFactory;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Wingu\Engine\SDK\Hydrator\Hydrator;

abstract class Api
{
    /** @var Configuration */
    protected $configuration;

    /** @var HttpClient */
    protected $httpClient;

    /** @var RequestFactory */
    protected $requestFactory;

    /** @var Hydrator */
    protected $hydrator;

    public function __construct(
        Configuration $configuration,
        HttpClient $httpClient,
        RequestFactory $requestFactory,
        Hydrator $hydrator
    ) {
        $this->configuration  = $configuration;
        $this->httpClient     = $httpClient;
        $this->requestFactory = $requestFactory;
        $this->hydrator       = $hydrator;
    }

    protected function handleRequest(RequestInterface $request) : ResponseInterface
    {
        $response = $this->httpClient->sendRequest($request);

        $statusCode = $response->getStatusCode();

        if ($statusCode >= 200 && $statusCode <= 299) {
            return $response;
        }

        switch ($statusCode) {
            case 400:
                throw new Exception\HttpClient\BadRequest('Bad request.', $response);
            case 401:
                throw new Exception\HttpClient\Unauthorized('Your credentials are incorrect.', $response);
            case 403:
                throw new Exception\HttpClient\Forbidden('You are not allowed to perform this action.', $response);
            case 404:
                throw new Exception\HttpClient\NotFound('Resource not found.', $response);
            case 500:
                throw new Exception\HttpClient\InternalServerError('Remote server error.', $response);
            default:
                throw new Exception\HttpClient('Unknown response.', $response);
        }
    }

    /** @param mixed[] $queryParameters */
    protected function createGetRequest(string $path, array $queryParameters = []) : RequestInterface
    {
        $uri = $this->configuration->backendUrl() . $path . '?' . \http_build_query($queryParameters);

        $request = $this->requestFactory->createRequest(
            'GET',
            $uri,
            [
                $this->configuration->apiKeyHeader() => $this->configuration->apiKey(),
            ]
        );

        return $request;
    }

    /** @return mixed[] */
    protected function decodeResponseBody(ResponseInterface $response) : array
    {
        $data = \json_decode($response->getBody()->getContents(), true);
        if (\json_last_error() !== \JSON_ERROR_NONE) {
            throw new Generic(\json_last_error_msg());
        }

        return $data;
    }
}
