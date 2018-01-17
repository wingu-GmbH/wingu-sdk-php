<?php

declare(strict_types = 1);

namespace Wingu\Engine\SDK\Serializer\Denormalizer;

use Speicher210\BusinessHours\BusinessHoursBuilder;
use Speicher210\BusinessHours\BusinessHoursInterface;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

final class FunctioningHoursDenormalizer implements DenormalizerInterface
{
    /**
     * @param mixed $data Data to restore
     * @param string $class The expected class to instantiate
     * @param string $format Format the given data was extracted from
     * @param array $context Options available to the denormalizer
     * @return mixed
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        if ($data === null) {
            return null;
        }

        $days = [];
        foreach ($data['days'] as $day) {
            if (!isset($day['dayOfWeek'], $day['intervals'])) {
                throw new NotNormalizableValueException('Invalid functioning hours.');
            }

            $days[] = [
                'dayOfWeek' => $day['dayOfWeek'],
                'openingIntervals' => $day['intervals']
            ];
        }

        $data['days'] = $days;

        try {
            return BusinessHoursBuilder::fromAssociativeArray($data);
        } catch (\Exception $e) {
            throw new NotNormalizableValueException('The provided data is not valid.', 0, $e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null): bool
    {
        if ($type !== BusinessHoursInterface::class) {
            return false;
        }

        return $data === null || isset($data['days'], $data['timezone']);
    }
}
