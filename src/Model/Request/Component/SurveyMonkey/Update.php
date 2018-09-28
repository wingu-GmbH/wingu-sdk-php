<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\SurveyMonkey;

use Wingu\Engine\SDK\Model\Request\Request;
use Wingu\Engine\SDK\Model\Request\StringValue;

final class Update implements Request
{
    /** @var StringValue|null */
    private $title;

    /** @var StringValue|null */
    private $description;

    /** @var string|null */
    private $surveyURL;

    public function __construct(?StringValue $title = null, ?StringValue $description = null, ?string $surveyURL = null)
    {
        $this->title       = $title;
        $this->description = $description;
        $this->surveyURL   = $surveyURL;
    }

    /** @inheritdoc */
    public function jsonSerialize() : array
    {
        return \array_filter([
            'title' => $this->title,
            'description' => $this->description,
            'surveyURL' => $this->surveyURL,
        ]);
    }
}
