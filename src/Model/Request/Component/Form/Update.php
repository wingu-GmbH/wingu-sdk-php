<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\Form;

use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\Component\Form\Element\Element;
use Wingu\Engine\SDK\Model\Request\Component\Form\Resubmit\Update as Resubmit;
use Wingu\Engine\SDK\Model\Request\Component\Form\SubmitDestination\SubmitDestination;
use Wingu\Engine\SDK\Model\Request\Request;

final class Update implements Request
{
    /** @var string|null */
    private $title;

    /** @var Element[] */
    private $elements;

    /** @var string */
    private $feedbackSuccessMessage;

    /** @var SubmitDestination[] */
    private $submitDestinations;

    /** @var Resubmit */
    private $resubmit;

    /**
     * @param Element[]           $elements
     * @param SubmitDestination[] $submitDestinations
     */
    public function __construct(
        ?string $title,
        array $elements,
        string $feedbackSuccessMessage,
        array $submitDestinations,
        Resubmit $resubmit
    ) {
        Assertion::notEmpty($elements);
        Assertion::allIsInstanceOf($elements, Element::class);
        Assertion::notEmpty($submitDestinations);
        Assertion::allIsInstanceOf($submitDestinations, SubmitDestination::class);
        $this->title                  = $title;
        $this->elements               = $elements;
        $this->feedbackSuccessMessage = $feedbackSuccessMessage;
        $this->submitDestinations     = $submitDestinations;
        $this->resubmit               = $resubmit;
    }

    /** @inheritdoc */
    public function jsonSerialize() : array
    {
        return [
            'title' => $this->title,
            'elements' => $this->elements,
            'feedbackSuccessMessage' => $this->feedbackSuccessMessage,
            'submitDestinations' => $this->submitDestinations,
            'resubmit' => $this->resubmit,
        ];
    }
}
