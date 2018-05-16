<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Tests\Serializer\Denormalizer;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Wingu\Engine\SDK\Model\Channel\Beacon\PrivateBeacon;
use Wingu\Engine\SDK\Model\Channel\Geofence\PrivateGeofence;
use Wingu\Engine\SDK\Model\Channel\Nfc\PrivateNfc;
use Wingu\Engine\SDK\Model\Channel\PrivateChannel;
use Wingu\Engine\SDK\Model\Channel\QrCode\PrivateQrCode;
use Wingu\Engine\SDK\Serializer\Denormalizer\PrivateChannelDenormalizer;

final class PrivateChannelDenormalizerTest extends TestCase
{
    public function testSettingSerializerThrowsExceptionIfItDoesNotImplementDenormalizerInterface() : void
    {
        $denormalizer   = new PrivateChannelDenormalizer();
        $serializerMock = $this->createMock(SerializerInterface::class);

        $this->expectException(InvalidArgumentException::class);

        $denormalizer->setSerializer($serializerMock);
    }

    /** @return mixed[] */
    public static function dataProviderTestDenormalizeCallsSerializerDenormalizeWithCorrectType() : array
    {
        return [
            ['beacon', PrivateBeacon::class],
            ['geofence', PrivateGeofence::class],
            ['nfc', PrivateNfc::class],
            ['qrcode', PrivateQrCode::class],
        ];
    }

    /**
     * @dataProvider dataProviderTestDenormalizeCallsSerializerDenormalizeWithCorrectType
     *
     */
    public function testDenormalizeCallsSerializerDenormalizeWithCorrectType(string $discriminator, string $class) : void
    {
        $data = ['discriminator' => $discriminator];

        $serializerMock = $this->createMock(Serializer::class);
        $serializerMock
            ->expects(self::once())
            ->method('denormalize')
            ->with($data, $class);

        $denormalizer = new PrivateChannelDenormalizer();
        $denormalizer->setSerializer($serializerMock);

        $denormalizer->denormalize($data, PrivateChannel::class);
    }
}
