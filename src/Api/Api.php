<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Api;

use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Discovery\StreamFactoryDiscovery;
use Http\Message\MultipartStream\MultipartStreamBuilder;
use Http\Message\RequestFactory;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\JsonSerializableNormalizer;
use Symfony\Component\Serializer\Serializer;
use Wingu\Engine\SDK\Api\Exception\Generic;
use Wingu\Engine\SDK\Hydrator\Hydrator;
use Wingu\Engine\SDK\Hydrator\SymfonySerializerHydrator;
use Wingu\Engine\SDK\Model\Request\MultipartRequest;
use Wingu\Engine\SDK\Model\Request\Request;
use Wingu\Engine\SDK\Request\RequestDataManipulator;

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

    /** @var Serializer */
    protected $serializer;

    public function __construct(
        Configuration $configuration,
        ?HttpClient $httpClient = null,
        ?RequestFactory $requestFactory = null,
        ?Hydrator $hydrator = null
    ) {
        $this->configuration  = $configuration;
        $this->httpClient     = $httpClient ?: HttpClientDiscovery::find();
        $this->requestFactory = $requestFactory ?: MessageFactoryDiscovery::find();
        $this->hydrator       = $hydrator ?: new SymfonySerializerHydrator();
        $this->serializer     = new Serializer([new JsonSerializableNormalizer()], [new JsonEncoder()]);
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
        $uri = $this->configuration->backendUrl() . $path;
        if ($queryParameters !== []) {
            $uri .= '?' . \http_build_query($queryParameters);
        }

        return $this->requestFactory->createRequest(
            'GET',
            $uri,
            [
                $this->configuration->apiKeyHeader() => $this->configuration->apiKey(),
            ]
        );
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

    protected function createPostRequest(string $path, Request $requestObject) : RequestInterface
    {
        $uri = $this->configuration->backendUrl() . $path;

        return $this->requestFactory->createRequest(
            'POST',
            $uri,
            [
                $this->configuration->apiKeyHeader() => $this->configuration->apiKey(),
                'Content-Type' => 'application/json',
            ],
            (string) \json_encode($requestObject)
        );
    }

    protected function createMultipartPostRequest(string $path, MultipartRequest $requestObject) : RequestInterface
    {
        $uri = $this->configuration->backendUrl() . $path;

        $builder = new MultipartStreamBuilder(StreamFactoryDiscovery::find());
        foreach (RequestDataManipulator::flatten($requestObject) as $name => $stream) {
            $builder->addResource($name, $stream);
        }
        foreach (RequestDataManipulator::flattenRequestData($requestObject->files()) as $name => $stream) {
            $builder->addResource($name, $stream);
        }
        $multipartStream = $builder->build();
        $boundary        = $builder->getBoundary();

        return $this->requestFactory->createRequest(
            'POST',
            $uri,
            [
                $this->configuration->apiKeyHeader() => $this->configuration->apiKey(),
                'Content-Type' => 'multipart/form-data; boundary="' . $boundary . '"',
            ],
            $multipartStream
        );
    }

    protected function createPatchRequest(string $path, Request $requestObject) : RequestInterface
    {
        $uri = $this->configuration->backendUrl() . $path;

        return $this->requestFactory->createRequest(
            'PATCH',
            $uri,
            [
                $this->configuration->apiKeyHeader() => $this->configuration->apiKey(),
                'Content-Type' => 'application/json',
            ],
            (string) \json_encode($requestObject)
        );
    }

    protected function createMultipartPatchRequest(string $path, MultipartRequest $requestObject) : RequestInterface
    {
        $uri = $this->configuration->backendUrl() . $path;

        $builder = new MultipartStreamBuilder(StreamFactoryDiscovery::find());
        foreach (RequestDataManipulator::flatten($requestObject) as $name => $stream) {
            $builder->addResource($name, $stream);
        }
        foreach (RequestDataManipulator::flattenRequestData($requestObject->files()) as $name => $stream) {
            $builder->addResource('image[image]', $stream);
        }
        $multipartStream = $builder->build();
        $boundary        = $builder->getBoundary();

        return $this->requestFactory->createRequest(
            'PATCH',
            $uri,
            [
                $this->configuration->apiKeyHeader() => $this->configuration->apiKey(),
                'Content-Type' => 'multipart/form-data; boundary="' . $boundary . '"',
            ],
            $multipartStream
        );
    }

    protected function createPutRequest(string $path, Request $requestObject) : RequestInterface
    {
        $uri = $this->configuration->backendUrl() . $path;

        return $this->requestFactory->createRequest(
            'PUT',
            $uri,
            [
                $this->configuration->apiKeyHeader() => $this->configuration->apiKey(),
                'Content-Type' => 'application/json',
            ],
            (string) \json_encode($requestObject)
        );
    }

    protected function createDeleteRequest(string $path) : RequestInterface
    {
        $uri = $this->configuration->backendUrl() . $path;

        return $this->requestFactory->createRequest(
            'DELETE',
            $uri,
            [
                $this->configuration->apiKeyHeader() => $this->configuration->apiKey(),
                'Content-Type' => 'application/json',
            ]
        );
    }
}
