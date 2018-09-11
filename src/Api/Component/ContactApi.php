<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Api\Component;

use Wingu\Engine\SDK\Api\Api;
use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\Component\Contact\Create;
use Wingu\Engine\SDK\Model\Request\Component\Contact\Update;
use Wingu\Engine\SDK\Model\Response\Component\Contact;

final class ContactApi extends Api
{
    public function create(Create $contact) : Contact
    {
        $request = $this->createPostRequest('/api/component/contact', $contact);

        $response = $this->handleRequest($request);

        return $this->hydrator->hydrateResponse($response, Contact::class);
    }

    public function update(string $id, Update $contact) : void
    {
        Assertion::uuid($id);
        $request = $this->createPatchRequest('/api/component/contact/' . $id, $contact);

        $this->handleRequest($request);
    }
}
