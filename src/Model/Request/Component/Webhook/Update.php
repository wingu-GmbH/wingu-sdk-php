<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\Webhook;

use Wingu\Engine\SDK\Model\Request\Request;

final class Update implements Request
{
    /** @var string|null */
    private $buttonCaption;

    /** @var string|null */
    private $feedbackSuccessMessage;

    /** @var string|null */
    private $url;

    public function __construct(string $buttonCaption, string $feedbackSuccessMessage, string $url)
    {
        $this->buttonCaption          = $buttonCaption;
        $this->feedbackSuccessMessage = $feedbackSuccessMessage;
        $this->url                    = $url;
    }

    /** @inheritdoc */
    public function jsonSerialize()
    {
        return [
            'buttonCaption' => $this->buttonCaption,
            'feedbackSuccessMessage' => $this->feedbackSuccessMessage,
            'url' => $this->url,
        ];
    }
}
