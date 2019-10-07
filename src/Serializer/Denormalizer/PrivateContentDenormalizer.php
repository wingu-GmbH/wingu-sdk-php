<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Serializer\Denormalizer;

use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Wingu\Engine\SDK\Model\Response\Content\Content;
use Wingu\Engine\SDK\Model\Response\Content\PrivateContent;
use Wingu\Engine\SDK\Model\Response\Content\PrivateListContent;

final class PrivateContentDenormalizer implements DenormalizerInterface, SerializerAwareInterface
{
    /** @var DenormalizerInterface */
    private $serializer;

    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $type, $format = null, array $context = []) : ?Content
    {
        if ($data === null) {
            return null;
        }

        if (isset($data['packs'])) {
            /** @var Content $content */
            $content = $this->serializer->denormalize($data, PrivateContent::class, $format, $context);
            return $content;
        }

        /** @var Content $content */
        $content = $this->serializer->denormalize($data, PrivateListContent::class, $format, $context);

        return $content;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null) : bool
    {
        return $type === Content::class;
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
