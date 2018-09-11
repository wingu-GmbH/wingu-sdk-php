<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Api\Component;

use Wingu\Engine\SDK\Api\Api;
use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\Component\Form\Create;
use Wingu\Engine\SDK\Model\Request\Component\Form\Update;
use Wingu\Engine\SDK\Model\Response\Component\PrivateForm;

final class FormApi extends Api
{
    public function create(Create $form) : PrivateForm
    {
        $request = $this->createPostRequest('/api/component/form', $form);

        $response = $this->handleRequest($request);

        return $this->hydrator->hydrateResponse($response, PrivateForm::class);
    }

    public function update(string $id, Update $form) : void
    {
        Assertion::uuid($id);
        $request = $this->createPatchRequest('/api/component/form/' . $id, $form);

        $this->handleRequest($request);
    }
}
