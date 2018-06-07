<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Serializer\Denormalizer;

use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Wingu\Engine\SDK\Model\Response\Country as CountryModel;

final class CountryDenormalizer implements DenormalizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        if (! \is_array($data)) {
            throw new InvalidArgumentException(\sprintf('Data expected to be an array, %s given.', \gettype($data)));
        }

        if (! isset($data['name'], $data['iso_3166_1_alpha_2'])) {
            throw new UnexpectedValueException('Expected a valid country data payload.');
        }

        try {
            return new CountryModel($data['iso_3166_1_alpha_2'], $data['name']);
        } catch (\Throwable $e) {
            throw new UnexpectedValueException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null) : bool
    {
        return $type === CountryModel::class;
    }
}
