<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Tests\Api;

use Http\Client\HttpClient;
use Http\Message\RequestFactory;
use PHPUnit\Framework\TestCase;
use Wingu\Engine\SDK\Api\Configuration;
use Wingu\Engine\SDK\Api\WinguApi;
use Wingu\Engine\SDK\Hydrator\Hydrator;

final class WinguApiTest extends TestCase
{
    public function testFetchingSameServicesReturnsSameInstance() : void
    {
        $winguApi = new WinguApi(
            new Configuration(),
            $this->createMock(HttpClient::class),
            $this->createMock(RequestFactory::class),
            $this->createMock(Hydrator::class)
        );

        $beacon  = $winguApi->beacon();
        $channel = $winguApi->channel();
        $wingu   = $winguApi->wingu();

        self::assertSame($beacon, $winguApi->beacon());
        self::assertSame($channel, $winguApi->channel());
        self::assertSame($wingu, $winguApi->wingu());
    }
}
