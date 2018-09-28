<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Api\Component;

use Wingu\Engine\SDK\Api\Api;
use Wingu\Engine\SDK\Api\Paginator\EmbeddedPage;
use Wingu\Engine\SDK\Api\Paginator\PageInfo;
use Wingu\Engine\SDK\Api\Paginator\PaginatedResponseIterator;
use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\Component\Copy;
use Wingu\Engine\SDK\Model\Response\Component\Component;

final class ComponentApi extends Api
{
    /** @var mixed[] */
    private $services = [];

    public function myComponent(string $id) : Component
    {
        $request = $this->createGetRequest('/api/component/' . $id . '.json');

        $response = $this->handleRequest($request);

        return $this->hydrator->hydrateResponse($response, Component::class);
    }

    public function copyMyComponent(string $id, Copy $component) : void
    {
        $request = $this->createPutRequest('/api/component/' . $id . '/copy', $component);

        $this->handleRequest($request);
    }

    public function myComponents() : PaginatedResponseIterator
    {
        $page = $this->getEmbeddedPage('/api/component/my.json');

        return new PaginatedResponseIterator(
            $page->pageInfo(),
            $page->embedded(),
            function () {
                return $this->getEmbeddedPage('/api/component/my.json');
            }
        );
    }

    public function deleteMyComponent(string $id) : void
    {
        Assertion::uuid($id);
        $request = $this->createDeleteRequest('/api/component/' . $id);

        $this->handleRequest($request);
    }

    private function getEmbeddedPage(string $path) : EmbeddedPage
    {
        $request = $this->createGetRequest($path);

        $response = $this->handleRequest($request);

        $data = $this->decodeResponseBody($response);

        $embedded = \array_map(
            static function ($data) {
                $discriminator         = $data['component']['discriminator'];
                $data                  = \reset($data);
                $data['discriminator'] = $discriminator;

                return $data;
            },
            $data['_embedded']['components']
        );

        $pageInfo = $this->hydrator->hydrateData($data, PageInfo::class);
        $embedded = $this->hydrator->hydrateData(
            $embedded,
            Component::class . '[]'
        );

        return new EmbeddedPage($pageInfo, $embedded);
    }

    public function action() : ActionApi
    {
        return $this->getService(ActionApi::class);
    }

    public function audioPlaylist() : AudioPlaylistApi
    {
        return $this->getService(AudioPlaylistApi::class);
    }

    public function brandBar() : BrandBarApi
    {
        return $this->getService(BrandBarApi::class);
    }

    public function cms() : CMSApi
    {
        return $this->getService(CMSApi::class);
    }

    public function contact() : ContactApi
    {
        return $this->getService(ContactApi::class);
    }

    public function coupon() : CouponApi
    {
        return $this->getService(CouponApi::class);
    }

    public function files() : FilesApi
    {
        return $this->getService(FilesApi::class);
    }

    public function form() : FormApi
    {
        return $this->getService(FormApi::class);
    }

    public function imageGallery() : ImageGalleryApi
    {
        return $this->getService(ImageGalleryApi::class);
    }

    public function location() : LocationApi
    {
        return $this->getService(LocationApi::class);
    }

    public function proxy() : ProxyApi
    {
        return $this->getService(ProxyApi::class);
    }

    public function rating() : RatingApi
    {
        return $this->getService(RatingApi::class);
    }

    public function separator() : SeparatorApi
    {
        return $this->getService(SeparatorApi::class);
    }

    public function surveyMonkey() : SurveyMonkeyApi
    {
        return $this->getService(SurveyMonkeyApi::class);
    }

    public function video() : VideoApi
    {
        return $this->getService(VideoApi::class);
    }

    public function webhook() : WebhookApi
    {
        return $this->getService(WebhookApi::class);
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
