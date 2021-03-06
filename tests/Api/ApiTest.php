<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Tests\Api;

use Http\Mock\Client as MockClient;
use PHPUnit\Framework\TestCase;

abstract class ApiTest extends TestCase
{
    protected static function createClient() : MockClient
    {
        return new MockClient();
    }

    protected function getDataFromFixturesFile(string $fileName) : ?string
    {
        $reflection = new \ReflectionObject($this);
        $file       = \dirname((string) $reflection->getFileName()) . '/Fixtures/' . $fileName;

        if (\file_exists($file)) {
            $fixtures = \file_get_contents($file);
            if ($fixtures === false) {
                throw new \RuntimeException('Could not access content of the file.');
            }

            return $fixtures;
        }

        return null;
    }
}
