<?php

declare(strict_types = 1);

namespace Wingu\Engine\SDK\Api;

use Http\Client\HttpClient;
use Http\Message\RequestFactory;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Wingu\Engine\SDK\Api\Exception as ApiException;
use Wingu\Engine\SDK\Hydrator\Hydrator;

abstract class Api
{
    protected $configuration;

    protected $httpClient;

    protected $requestFactory;

    protected $hydrator;

    public function __construct(
        Configuration $configuration,
        HttpClient $httpClient,
        RequestFactory $requestFactory,
        Hydrator $hydrator
    ) {
        $this->configuration = $configuration;
        $this->httpClient = $httpClient;
        $this->requestFactory = $requestFactory;
        $this->hydrator = $hydrator;
    }

    protected function handleRequest(RequestInterface $request): ResponseInterface
    {
        $response = $this->httpClient->sendRequest($request);

        $statusCode = $response->getStatusCode();

        if ($statusCode >= 200 && $statusCode <= 299) {
            return $response;
        }

        switch ($statusCode) {
            case 400:
                throw new ApiException\HttpClient\BadRequest('Bad request.', $response);
            case 401:
                throw new ApiException\HttpClient\Unauthorized('Your credentials are incorrect.', $response);
            case 403:
                throw new ApiException\HttpClient\Forbidden('You are not allowed to perform this action.', $response);
            case 404:
                throw new ApiException\HttpClient\NotFound('Resource not found.', $response);
            case 500:
                throw new ApiException\HttpClient\InternalServerError('Remote server error.', $response);
            default:
                throw new ApiException\HttpClient('Unknown response.', $response);
        }
    }

    protected function createGetRequest(string $path, array $queryParameters = []): RequestInterface
    {
        $uri = $this->configuration->backendUrl() . $path . '?' . \http_build_query($queryParameters);

        $request = $this->requestFactory->createRequest(
            'GET',
            $uri,
            [
                $this->configuration->apiKeyHeader() => $this->configuration->apiKey()
            ]
        );

        return $request;
    }

    protected function decodeResponseBody(ResponseInterface $response): array
    {
        $data = \json_decode($response->getBody()->getContents(), true);
        if (\json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception(\json_last_error_msg());
        }

        return $data;
    }
}
