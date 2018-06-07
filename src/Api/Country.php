<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Api;

use Wingu\Engine\SDK\Model\Response\Country as CountryModel;

final class Country extends Api
{
    /**
     * @return CountryModel[]
     */
    public function countries() : array
    {
        $request = $this->createGetRequest('/api/country.json');

        $response = $this->handleRequest($request);

        return $this->hydrator->hydrateResponse($response, CountryModel::class . '[]');
    }
}
