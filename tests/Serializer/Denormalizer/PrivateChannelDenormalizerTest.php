<?php

declare(strict_types = 1);

namespace Wingu\Engine\SDK\Tests\Serializer\Denormalizer;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\SerializerInterface;
use Wingu\Engine\SDK\Serializer\Denormalizer\PrivateChannelDenormalizer;

final class PrivateChannelDenormalizerTest extends TestCase
{
    public function testSettingSerializerThrowsExceptionIfItDoesNotImplementDenormalizerInterface(): void
    {
        $denormalizer = new PrivateChannelDenormalizer();
        $serializerMock = $this->createMock(SerializerInterface::class);

        $this->expectException(InvalidArgumentException::class);

        $denormalizer->setSerializer($serializerMock);
    }

    public function testDenormalizeCallsSerializerDenormalizeWithCorrectType(): void
    {
        self::markTestIncomplete('Not implemented. Should use data provider.');
    }
}
