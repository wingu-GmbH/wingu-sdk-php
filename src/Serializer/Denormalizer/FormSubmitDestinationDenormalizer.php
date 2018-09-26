<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Serializer\Denormalizer;

use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Wingu\Engine\SDK\Model\Response\Component\SubmitDestination\Email;
use Wingu\Engine\SDK\Model\Response\Component\SubmitDestination\Endpoint;
use Wingu\Engine\SDK\Model\Response\Component\SubmitDestination\SubmitDestination;

final class FormSubmitDestinationDenormalizer implements DenormalizerInterface, SerializerAwareInterface
{
    /** @var DenormalizerInterface */
    private $serializer;

    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        switch ($data['discriminator']) {
            case 'email':
                return $this->serializer->denormalize($data, Email::class, $format, $context);
            case 'endpoint':
                return $this->serializer->denormalize($data, Endpoint::class, $format, $context);
            default:
                throw new UnexpectedValueException(\sprintf('Unknown Form SubmitDestination type "%s".', $data['discriminator']));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null) : bool
    {
        return $type === SubmitDestination::class;
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
