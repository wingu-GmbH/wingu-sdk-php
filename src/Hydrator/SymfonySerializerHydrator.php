<?php

declare(strict_types = 1);

namespace Wingu\Engine\SDK\Hydrator;

use Psr\Http\Message\ResponseInterface;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Serializer;
use Wingu\Engine\SDK\Serializer\Denormalizer\CountryDenormalizer;
use Wingu\Engine\SDK\Serializer\Denormalizer\FunctioningHoursDenormalizer;
use Wingu\Engine\SDK\Serializer\Denormalizer\ObjectDenormalizer;
use Wingu\Engine\SDK\Serializer\Denormalizer\PrivateChannelDenormalizer;

final class SymfonySerializerHydrator implements Hydrator
{
    private $serializer;

    public function __construct()
    {
        $this->serializer = new Serializer(
            [
                new ArrayDenormalizer(),
                new PrivateChannelDenormalizer(),
                new CountryDenormalizer(),
                new FunctioningHoursDenormalizer(),
                new ObjectDenormalizer(null, null, null, new PhpDocExtractor())
            ],
            [new JsonEncoder()]
        );
    }

    public function hydrateData(array $data, string $class)
    {
        try {
            return $this->serializer->denormalize($data, $class);
        } catch (\Exception $exception) {
            throw new HydrationException('Could not hydrate response.', 0, $exception);
        }
    }

    public function hydrateResponse(ResponseInterface $response, string $class)
    {
        $contentType = $response->getHeaderLine('Content-Type');
        if ($contentType !== 'application/json' && \strpos($contentType, 'application/json+') !== 0) {
            throw new HydrationException(
                \sprintf(
                    'The %s cannot hydrate response with Content-Type: %s',
                    __CLASS__,
                    $contentType
                )
            );
        }

        try {
            return $this->serializer
                ->deserialize(
                    $response->getBody()->getContents(),
                    $class,
                    'json'
                );
        } catch (\Exception $exception) {
            throw new HydrationException('Could not hydrate response.', 0, $exception);
        }
    }
}
