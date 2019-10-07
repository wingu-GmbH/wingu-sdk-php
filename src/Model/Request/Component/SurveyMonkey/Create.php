<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\SurveyMonkey;

use Wingu\Engine\SDK\Model\Request\Request;

final class Create implements Request
{
    /** @var string|null */
    private $title;

    /** @var string|null */
    private $description;

    /** @var string */
    private $surveyURL;

    public function __construct(?string $title, ?string $description, string $surveyURL)
    {
        $this->title       = $title;
        $this->description = $description;
        $this->surveyURL   = $surveyURL;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize() : array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'surveyURL' => $this->surveyURL,
        ];
    }
}
