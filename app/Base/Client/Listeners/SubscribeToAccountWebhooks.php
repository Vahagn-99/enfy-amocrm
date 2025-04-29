<?php

namespace App\Base\Client\Listeners;

use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Exceptions\AmoCRMMissedTokenException;
use AmoCRM\Exceptions\AmoCRMoAuthApiException;
use AmoCRM\Helpers\EntityTypesInterface;
use AmoCRM\Models\CustomFields\CustomFieldModel;
use AmoCRM\Models\WebhookModel;
use App\Base\Client\Events\WidgetInstalled;
use App\Services\AmoCRM\Core\Facades\Amo;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Spatie\LaravelData\DataCollection;

class SubscribeToAccountWebhooks implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(WidgetInstalled $event) : void
    {
        $client = $event->client;

        Amo::setAccount($client);


        $amo_webhook = new  WebhookModel();
        $amo_webhook->setCreatedBy($client->id);
        $amo_webhook->setDestination(route('amocrm.webhook', [
            'api_key' => "some_api_key", // ставим сюда api_key для клиента, и обноволяем его каждый день по крону. также ставим сообитие на обновление вебхука в AmoCRM.
        ]));
        $amo_webhook->setSettings([
            'add_lead',
            'update_lead',
            'add_contact',
            'update_contact',
        ]);

        $exists_webhook_id = $client->embedded->used_webhook_id;

        if (isset($exists_webhook_id)) {
            $amo_webhook->setId($exists_webhook_id);
        }

        try {
            Amo::entities()->webhookApi()->sync($amo_webhook);
        } catch (AmoCRMMissedTokenException|AmoCRMoAuthApiException|AmoCRMApiException $e) {
            alt_log()->file('error_amocrm')->error("Не удалось подписаться на вебхук для клиента {$event->client->domain}".json_encode([
                    'message' => $e->getMessage(),
                    'error' => $e->getDescription(),
                ]));
        }
    }
}
