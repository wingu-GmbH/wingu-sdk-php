<?php

declare(strict_types = 1);

namespace Wingu\Engine\SDK\Api;

use Http\Client\HttpClient;
use Http\Message\RequestFactory;
use Wingu\Engine\SDK\Api\Channel\Beacon\Beacon;
use Wingu\Engine\SDK\Api\Channel\Channel;
use Wingu\Engine\SDK\Api\Content\Category;
use Wingu\Engine\SDK\Api\Wingu\Wingu;
use Wingu\Engine\SDK\Hydrator\Hydrator;

final class WinguApi
{
    private $configuration;

    private $httpClient;

    private $requestFactory;

    private $hydrator;

    private $services = [];

    public function __construct(
        Configuration $configuration,
        HttpClient $httpClient,
        RequestFactory $requestFactory,
        Hydrator $hydrator
    ) {
        $this->configuration = $configuration;
        $this->httpClient = $httpClient;
        $this->requestFactory = $requestFactory;
        $this->hydrator = $hydrator;
    }

    public function channel(): Channel
    {
        return $this->getService(Channel::class);
    }

    public function beacon(): Beacon
    {
        return $this->getService(Beacon::class);
    }

    public function category(): Category
    {
        return $this->getService(Category::class);
    }

    public function wingu(): Wingu
    {
        return $this->getService(Wingu::class);
    }

    private function getService(string $class)
    {
        if (!isset($this->services[$class])) {
            $this->services[$class] = new $class(
                $this->configuration,
                $this->httpClient,
                $this->requestFactory,
                $this->hydrator
            );
        }

        return $this->services[$class];
    }
}
