<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Api;

use Http\Client\HttpClient;
use Http\Message\RequestFactory;
use Wingu\Engine\SDK\Api\Channel\Beacon\BeaconApi;
use Wingu\Engine\SDK\Api\Channel\ChannelApi;
use Wingu\Engine\SDK\Api\Channel\Geofence\GeofenceApi;
use Wingu\Engine\SDK\Api\Channel\Nfc\NfcApi;
use Wingu\Engine\SDK\Api\Channel\QrCode\QrCodeApi;
use Wingu\Engine\SDK\Api\Component\ComponentApi;
use Wingu\Engine\SDK\Api\Content\Content;
use Wingu\Engine\SDK\Api\Content\Template;
use Wingu\Engine\SDK\Api\Wingu\Wingu;
use Wingu\Engine\SDK\Hydrator\Hydrator;

final class WinguApi
{
    /** @var Configuration */
    private $configuration;

    /** @var HttpClient */
    private $httpClient;

    /** @var RequestFactory */
    private $requestFactory;

    /** @var Hydrator */
    private $hydrator;

    /** @var mixed[] */
    private $services = [];

    public function __construct(
        Configuration $configuration,
        HttpClient $httpClient,
        RequestFactory $requestFactory,
        Hydrator $hydrator
    ) {
        $this->configuration  = $configuration;
        $this->httpClient     = $httpClient;
        $this->requestFactory = $requestFactory;
        $this->hydrator       = $hydrator;
    }

    public function channel() : ChannelApi
    {
        return $this->getService(ChannelApi::class);
    }

    public function beacon() : BeaconApi
    {
        return $this->getService(BeaconApi::class);
    }

    public function geofence() : GeofenceApi
    {
        return $this->getService(GeofenceApi::class);
    }

    public function nfc() : NfcApi
    {
        return $this->getService(NfcApi::class);
    }

    public function qrCode() : QrCodeApi
    {
        return $this->getService(QrCodeApi::class);
    }

    public function component() : ComponentApi
    {
        return $this->getService(ComponentApi::class);
    }

    public function content() : Content
    {
        return $this->getService(Content::class);
    }

    public function contentTemplate() : Template
    {
        return $this->getService(Template::class);
    }

    public function wingu() : Wingu
    {
        return $this->getService(Wingu::class);
    }

    public function country() : Country
    {
        return $this->getService(Country::class);
    }

    public function deck() : Deck
    {
        return $this->getService(Deck::class);
    }

    public function card() : Card
    {
        return $this->getService(Card::class);
    }

    /** @return mixed */
    private function getService(string $class)
    {
        if (! isset($this->services[$class])) {
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
