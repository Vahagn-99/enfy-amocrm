<?php

namespace App\Services\AmoCRM\Entities;

use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Models\WebhookModel;

class WebhookApi
{
    /**
     * WebhookApi constructor
     *
     * @param \AmoCRM\Client\AmoCRMApiClient $apiClient
     */
    public function __construct(private readonly AmoCRMApiClient $apiClient)
    {
        //
    }

    /**
     * Создание или обновление вебхука.
     *
     * @param \AmoCRM\Models\WebhookModel $webhook
     * @param string|null $exist_webhook_id
     *
     * @return \AmoCRM\Models\WebhookModel
     * @throws \AmoCRM\Exceptions\AmoCRMApiException
     * @throws \AmoCRM\Exceptions\AmoCRMMissedTokenException
     * @throws \AmoCRM\Exceptions\AmoCRMoAuthApiException
     * @throws \AmoCRM\Exceptions\NotAvailableForActionException
     */
    public function sync(WebhookModel $webhook, ?string $exist_webhook_id = null) : WebhookModel
    {
        $api = $this->apiClient->webhooks();

        if (isset($exist_webhook_id)) {
            $webhook->setId($exist_webhook_id);

            $api->unsubscribe($webhook);
        }

        return $api->subscribe($webhook);
    }
}
