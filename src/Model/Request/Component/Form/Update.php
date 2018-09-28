<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\Form;

use Assert\Assert;
use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\Component\Form\Element\Element;
use Wingu\Engine\SDK\Model\Request\Component\Form\Resubmit\Update as Resubmit;
use Wingu\Engine\SDK\Model\Request\Component\Form\SubmitDestination\SubmitDestination;
use Wingu\Engine\SDK\Model\Request\Request;

final class Update implements Request
{
    /** @var string|null */
    private $title;

    /** @var Element[]|null */
    private $elements;

    /** @var string|null */
    private $feedbackSuccessMessage;

    /** @var SubmitDestination[]|null */
    private $submitDestinations;

    /** @var Resubmit|null */
    private $resubmit;

    /**
     * @param Element[]|null           $elements
     * @param SubmitDestination[]|null $submitDestinations
     */
    public function __construct(
        ?string $title = null,
        ?array $elements = null,
        ?string $feedbackSuccessMessage = null,
        ?array $submitDestinations = null,
        ?Resubmit $resubmit = null
    ) {
        Assertion::nullOrNotEmpty($elements);
        Assert::thatNullOr($elements)->all()->isInstanceOf(Element::class);
        Assertion::nullOrNotEmpty($submitDestinations);
        Assert::thatNullOr($submitDestinations)->all()->isInstanceOf(SubmitDestination::class);

        $this->title                  = $title;
        $this->elements               = $elements;
        $this->feedbackSuccessMessage = $feedbackSuccessMessage;
        $this->submitDestinations     = $submitDestinations;
        $this->resubmit               = $resubmit;
    }

    /** @inheritdoc */
    public function jsonSerialize() : array
    {
        return \array_filter([
            'title' => $this->title,
            'elements' => $this->elements,
            'feedbackSuccessMessage' => $this->feedbackSuccessMessage,
            'submitDestinations' => $this->submitDestinations,
            'resubmit' => $this->resubmit,
        ]);
    }
}
