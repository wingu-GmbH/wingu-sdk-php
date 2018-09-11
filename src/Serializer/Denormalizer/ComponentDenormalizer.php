<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Serializer\Denormalizer;

use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Wingu\Engine\SDK\Model\Response\Component\Action;
use Wingu\Engine\SDK\Model\Response\Component\AudioPlaylist;
use Wingu\Engine\SDK\Model\Response\Component\BrandBar;
use Wingu\Engine\SDK\Model\Response\Component\CMS;
use Wingu\Engine\SDK\Model\Response\Component\Component;
use Wingu\Engine\SDK\Model\Response\Component\Contact;
use Wingu\Engine\SDK\Model\Response\Component\Coupon;
use Wingu\Engine\SDK\Model\Response\Component\Files;
use Wingu\Engine\SDK\Model\Response\Component\ImageGallery;
use Wingu\Engine\SDK\Model\Response\Component\Location;
use Wingu\Engine\SDK\Model\Response\Component\PrivateForm;
use Wingu\Engine\SDK\Model\Response\Component\PrivateWebhook;
use Wingu\Engine\SDK\Model\Response\Component\Proxy;
use Wingu\Engine\SDK\Model\Response\Component\PublicForm;
use Wingu\Engine\SDK\Model\Response\Component\PublicWebhook;
use Wingu\Engine\SDK\Model\Response\Component\Rating;
use Wingu\Engine\SDK\Model\Response\Component\Separator;
use Wingu\Engine\SDK\Model\Response\Component\SurveyMonkey;
use Wingu\Engine\SDK\Model\Response\Component\Video;

final class ComponentDenormalizer implements DenormalizerInterface, SerializerAwareInterface
{
    /** @var DenormalizerInterface */
    private $serializer;

    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        switch ($data['discriminator']) {
            case 'action':
                return $this->serializer->denormalize($data, Action::class, $format, $context);
            case 'audio_playlist':
                return $this->serializer->denormalize($data, AudioPlaylist::class, $format, $context);
            case 'brand_bar':
                return $this->serializer->denormalize($data, BrandBar::class, $format, $context);
            case 'cms':
                return $this->serializer->denormalize($data, CMS::class, $format, $context);
            case 'contact':
                return $this->serializer->denormalize($data, Contact::class, $format, $context);
            case 'coupon':
                return $this->serializer->denormalize($data, Coupon::class, $format, $context);
            case 'files':
                return $this->serializer->denormalize($data, Files::class, $format, $context);
            case 'form':
                if (isset($data['feedbackSuccessMessage'])) {
                    return $this->serializer->denormalize($data, PrivateForm::class, $format, $context);
                }
                return $this->serializer->denormalize($data, PublicForm::class, $format, $context);
            case 'image_gallery':
                return $this->serializer->denormalize($data, ImageGallery::class, $format, $context);
            case 'location':
                return $this->serializer->denormalize($data, Location::class, $format, $context);
            case 'proxy':
                return $this->serializer->denormalize($data, Proxy::class, $format, $context);
            case 'rating':
                return $this->serializer->denormalize($data, Rating::class, $format, $context);
            case 'separator':
                return $this->serializer->denormalize($data, Separator::class, $format, $context);
            case 'survey_monkey':
                return $this->serializer->denormalize($data, SurveyMonkey::class, $format, $context);
            case 'video':
                return $this->serializer->denormalize($data, Video::class, $format, $context);
            case 'webhook':
                if (isset($data['feedbackSuccessMessage'])) {
                    return $this->serializer->denormalize($data, PrivateWebhook::class, $format, $context);
                }
                return $this->serializer->denormalize($data, PublicWebhook::class, $format, $context);
            default:
                throw new UnexpectedValueException(\sprintf('Unknown component type "%s".', $data['discriminator']));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null) : bool
    {
        return $type === Component::class;
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
