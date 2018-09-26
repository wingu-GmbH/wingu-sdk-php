<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Serializer\Denormalizer;

use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Wingu\Engine\SDK\Model\Response\Component\Element\Element;
use Wingu\Engine\SDK\Model\Response\Component\Element\Input;
use Wingu\Engine\SDK\Model\Response\Component\Element\Select;

final class FormElementDenormalizer implements DenormalizerInterface, SerializerAwareInterface
{
    /** @var DenormalizerInterface */
    private $serializer;

    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        switch ($data['discriminator']) {
            case 'input':
                return $this->serializer->denormalize($data, Input::class, $format, $context);
            case 'select':
                return $this->serializer->denormalize($data, Select::class, $format, $context);
            default:
                throw new UnexpectedValueException(\sprintf('Unknown Form Element type "%s".', $data['discriminator']));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null) : bool
    {
        return $type === Element::class;
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
