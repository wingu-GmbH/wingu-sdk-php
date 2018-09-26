<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Response\Component;

use Assert\Assertion;
use Wingu\Engine\SDK\Model\Response\Component\Element\Element;
use Wingu\Engine\SDK\Model\Response\Component\SubmitDestination\SubmitDestination;

class PrivateForm implements Component
{
    use ComponentTrait;

    /** @var string */
    private $title;

    /** @var Element[] */
    private $elements;

    /** @var SubmitDestination[] */
    private $submitDestinations;

    /** @var string */
    private $feedbackSuccessMessage;

    /**
     * @param Element[]           $elements
     * @param SubmitDestination[] $submitDestinations
     */
    public function __construct(
        string $id,
        \DateTime $updatedAt,
        string $title,
        array $elements,
        array $submitDestinations,
        string $feedbackSuccessMessage
    ) {
        Assertion::notEmpty($elements);
        Assertion::notEmpty($submitDestinations);
        Assertion::allIsInstanceOf($elements, Element::class);
        Assertion::allIsInstanceOf($submitDestinations, SubmitDestination::class);

        $this->id                     = $id;
        $this->updatedAt              = $updatedAt;
        $this->title                  = $title;
        $this->elements               = $elements;
        $this->submitDestinations     = $submitDestinations;
        $this->feedbackSuccessMessage = $feedbackSuccessMessage;
    }

    public function title() : string
    {
        return $this->title;
    }

    /** @return Element[] */
    public function elements() : array
    {
        return $this->elements;
    }

    /** @return SubmitDestination[] */
    public function submitDestinations() : array
    {
        return $this->submitDestinations;
    }

    public function feedbackSuccessMessage() : string
    {
        return $this->feedbackSuccessMessage;
    }
}
