<?php

declare(strict_types = 1);

namespace Wingu\Engine\SDK\Tests\Hydrator;

use PHPUnit\Framework\TestCase;

final class SymfonySerializerHydratorTest extends TestCase
{
    public function testHydrateResponseThrowsExceptionWhenContentTypeIsNotJson(): void
    {
        self::markTestIncomplete('Not implemented.');
    }

    public function testHydrateResponseValidatesContentTypes(): void
    {
        self::markTestIncomplete('Not implemented. Should use data provider.');
    }
}
