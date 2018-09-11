<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\Form;

use Wingu\Engine\SDK\Model\Request\Component\Form\Resubmit\Create as Resubmit;
use Wingu\Engine\SDK\Model\Request\Request;

final class Create implements Request
{
    /** @var string */
    private $title;

    /** todo: Element[]
     * private $elements;
     */

    /** @var string */
    private $feedbackSuccessMessage;

    /** todo: SubmitDestinations
     * private $submitDestinations;
     */

    /** @var Resubmit */
    private $resubmit;

    public function __construct(
        string $title,
        //        string $elements,
        string $feedbackSuccessMessage,
        //        string $submitDestinations,
        Resubmit $resubmit
    ) {
        $this->title = $title;
//        $this->elements               = $elements;
        $this->feedbackSuccessMessage = $feedbackSuccessMessage;
//        $this->submitDestinations     = $submitDestinations;
        $this->resubmit = $resubmit;
    }

    /** @inheritdoc */
    public function jsonSerialize()
    {
        return [
            'title' => $this->title,
//            'elements' => $this->elements,
            'feedbackSuccessMessage' => $this->feedbackSuccessMessage,
//            'submitDestinations' => $this->submitDestinations,
            'resubmit' => $this->resubmit,
        ];
    }
}
