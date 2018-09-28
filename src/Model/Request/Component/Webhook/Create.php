<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\Webhook;

use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\Request;

final class Create implements Request
{
    /** @var string */
    private $buttonCaption;

    /** @var string */
    private $feedbackSuccessMessage;

    /** @var string */
    private $url;

    public function __construct(string $buttonCaption, string $feedbackSuccessMessage, string $url)
    {
        Assertion::url($url);

        $this->buttonCaption          = $buttonCaption;
        $this->feedbackSuccessMessage = $feedbackSuccessMessage;
        $this->url                    = $url;
    }

    /** @inheritdoc */
    public function jsonSerialize() : array
    {
        return [
            'buttonCaption' => $this->buttonCaption,
            'feedbackSuccessMessage' => $this->feedbackSuccessMessage,
            'url' => $this->url,
        ];
    }
}
