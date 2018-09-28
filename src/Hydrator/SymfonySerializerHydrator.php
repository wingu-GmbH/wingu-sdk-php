<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Hydrator;

use Psr\Http\Message\ResponseInterface;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Serializer;
use Wingu\Engine\SDK\Serializer\Denormalizer\ComponentDenormalizer;
use Wingu\Engine\SDK\Serializer\Denormalizer\CountryDenormalizer;
use Wingu\Engine\SDK\Serializer\Denormalizer\FormElementDenormalizer;
use Wingu\Engine\SDK\Serializer\Denormalizer\FormSubmitDestinationDenormalizer;
use Wingu\Engine\SDK\Serializer\Denormalizer\FunctioningHoursDenormalizer;
use Wingu\Engine\SDK\Serializer\Denormalizer\ObjectDenormalizer;
use Wingu\Engine\SDK\Serializer\Denormalizer\PrivateChannelDenormalizer;
use Wingu\Engine\SDK\Serializer\Denormalizer\PrivateContentDenormalizer;
use Wingu\Engine\SDK\Serializer\Denormalizer\RatingsDenormalizer;

final class SymfonySerializerHydrator implements Hydrator
{
    /** @var Serializer */
    private $serializer;

    public function __construct()
    {
        $this->serializer = new Serializer(
            [
                new FormElementDenormalizer(),
                new FormSubmitDestinationDenormalizer(),
                new RatingsDenormalizer(),
                new ComponentDenormalizer(),
                new PrivateContentDenormalizer(),
                new DateTimeNormalizer(),
                new ArrayDenormalizer(),
                new PrivateChannelDenormalizer(),
                new CountryDenormalizer(),
                new FunctioningHoursDenormalizer(),
                new ObjectDenormalizer(null, null, null, new PhpDocExtractor()),
            ],
            [new JsonEncoder()]
        );
    }

    /**
     * @param mixed[] $data
     *
     * @return mixed
     */
    public function hydrateData(array $data, string $class)
    {
        try {
            return $this->serializer->denormalize($data, $class);
        } catch (\Throwable $exception) {
            throw new Hydration('Could not hydrate response.', 0, $exception);
        }
    }

    /** @return mixed */
    public function hydrateResponse(ResponseInterface $response, string $class)
    {
        $contentType = $response->getHeaderLine('Content-Type');
        if ($contentType !== 'application/json' && \strpos($contentType, 'application/json+') !== 0) {
            throw new Hydration(
                \sprintf(
                    'The %s cannot hydrate response with Content-Type: %s',
                    self::class,
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
        } catch (\Throwable $exception) {
            throw new Hydration('Could not hydrate response.', 0, $exception);
        }
    }
}
