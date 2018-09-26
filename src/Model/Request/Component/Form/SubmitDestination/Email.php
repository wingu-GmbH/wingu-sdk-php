<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Request\Component\Form\SubmitDestination;

use Wingu\Engine\SDK\Assertion;

final class Email implements SubmitDestination
{
    /** @var string */
    private $email;

    public function __construct(string $email)
    {
        Assertion::email($email);
        $this->email = $email;
    }

    public function email() : string
    {
        return $this->email;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize() : array
    {
        return [
            'email'         => $this->email,
            'discriminator' => 'email',
        ];
    }
}
