<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Api\Content;

use Wingu\Engine\SDK\Api\Api;
use Wingu\Engine\SDK\Model\Response\Content\Locale as ResponseLocale;

final class Locale extends Api
{
    /** @return ResponseLocale[] */
    public function locales() : array
    {
        $request = $this->createGetRequest('/api/content/locale');

        $response = $this->handleRequest($request);

        return $this->hydrator->hydrateResponse($response, ResponseLocale::class . '[]');
    }
}
