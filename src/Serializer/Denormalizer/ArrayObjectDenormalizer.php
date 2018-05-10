<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Serializer\Denormalizer;

use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerInterface;

final class ArrayObjectDenormalizer implements DenormalizerInterface, SerializerAwareInterface
{
    /** @var DenormalizerInterface */
    private $serializer;

    /** @var string */
    private $supportedClass;

    /** @var string */
    private $className;

    public function __construct(string $supportedClass, string $className)
    {
        if (! \in_array(\ArrayObject::class, \class_parents($supportedClass), true)) {
            throw new \LogicException(\sprintf(
                'Class %s does not extend %s class',
                $supportedClass,
                \ArrayObject::class
            ));
        }
        $this->supportedClass = $supportedClass;
        $this->className      = $className;
    }

    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        if (! \is_array($data)) {
            throw new InvalidArgumentException(\sprintf('Data expected to be an array, %s given.', \gettype($data)));
        }

        $input = $this->serializer->denormalize($data, $this->className . '[]', $format, $context);

        return new $this->supportedClass($input);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null) : bool
    {
        return $type === $this->supportedClass;
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
