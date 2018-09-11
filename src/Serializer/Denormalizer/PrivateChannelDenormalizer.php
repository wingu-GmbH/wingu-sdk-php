<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Serializer\Denormalizer;

use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Wingu\Engine\SDK\Model\Response\Channel\Beacon\PrivateBeacon;
use Wingu\Engine\SDK\Model\Response\Channel\Geofence\PrivateGeofence;
use Wingu\Engine\SDK\Model\Response\Channel\Nfc\PrivateNfc;
use Wingu\Engine\SDK\Model\Response\Channel\PrivateChannel;
use Wingu\Engine\SDK\Model\Response\Channel\QrCode\PrivateQrCode;

final class PrivateChannelDenormalizer implements DenormalizerInterface, SerializerAwareInterface
{
    /** @var DenormalizerInterface */
    private $serializer;

    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        switch ($data['discriminator']) {
            case 'beacon':
                return $this->serializer->denormalize($data, PrivateBeacon::class, $format, $context);
            case 'geofence':
                return $this->serializer->denormalize($data, PrivateGeofence::class, $format, $context);
            case 'nfc':
                return $this->serializer->denormalize($data, PrivateNfc::class, $format, $context);
            case 'qrcode':
                return $this->serializer->denormalize($data, PrivateQrCode::class, $format, $context);
            default:
                throw new UnexpectedValueException(\sprintf('Unknown channel type "%s".', $data['discriminator']));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null) : bool
    {
        return $type === PrivateChannel::class;
    }

    /**
     * {@inheritdoc}
     */
    public function setSerializer(SerializerInterface $serializer) : void
    {
        if (! $serializer instanceof DenormalizerInterface) {
            throw new InvalidArgumentException(
                \sprintf('Expected a serializer that also implements %s.', DenormalizerInterface::class)
            );
        }

        $this->serializer = $serializer;
    }
}
