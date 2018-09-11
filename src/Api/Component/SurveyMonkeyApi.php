<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Api\Component;

use Wingu\Engine\SDK\Api\Api;
use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\Component\SurveyMonkey\Create;
use Wingu\Engine\SDK\Model\Request\Component\SurveyMonkey\Update;
use Wingu\Engine\SDK\Model\Response\Component\SurveyMonkey;

final class SurveyMonkeyApi extends Api
{
    public function create(Create $surveyMonkey) : SurveyMonkey
    {
        $request = $this->createPostRequest('/api/component/survey_monkey', $surveyMonkey);

        $response = $this->handleRequest($request);

        return $this->hydrator->hydrateResponse($response, SurveyMonkey::class);
    }

    public function update(string $id, Update $surveyMonkey) : void
    {
        Assertion::uuid($id);
        $request = $this->createPatchRequest('/api/component/survey_monkey/' . $id, $surveyMonkey);

        $this->handleRequest($request);
    }
}
