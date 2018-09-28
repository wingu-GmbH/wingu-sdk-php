<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Api\Component;

use Wingu\Engine\SDK\Api\Api;
use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\Component\Webhook\Create;
use Wingu\Engine\SDK\Model\Request\Component\Webhook\Update;
use Wingu\Engine\SDK\Model\Response\Component\PrivateWebhook;
use Wingu\Engine\SDK\Model\Response\Component\WebhookTrigger;

final class WebhookApi extends Api
{
    public function create(Create $webhook) : PrivateWebhook
    {
        $request = $this->createPostRequest('/api/component/webhook', $webhook);

        $response = $this->handleRequest($request);

        return $this->hydrator->hydrateResponse($response, PrivateWebhook::class);
    }

    public function update(string $id, Update $webhook) : void
    {
        Assertion::uuid($id);
        $request = $this->createPatchRequest('/api/component/webhook/' . $id, $webhook);

        $this->handleRequest($request);
    }

    public function trigger(string $id) : WebhookTrigger
    {
        Assertion::uuid($id);
        $request = $this->createGetRequest('/api/component/webhook/' . $id . '/trigger');

        $response = $this->handleRequest($request);

        return $this->hydrator->hydrateResponse($response, WebhookTrigger::class);
    }
}
