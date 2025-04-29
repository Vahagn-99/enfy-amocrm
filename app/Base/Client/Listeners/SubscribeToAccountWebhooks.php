<?php

namespace App\Base\Client\Listeners;


use AmoCRM\Models\WebhookModel;
use App\Base\Client\Events\AmoAccountAuthenticated;
use App\Services\AmoCRM\Core\Facades\Amo;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use AmoCRM\Exceptions\{
    AmoCRMApiException,
    AmoCRMMissedTokenException,
    AmoCRMoAuthApiException,
};

class SubscribeToAccountWebhooks implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(AmoAccountAuthenticated $event) : void
    {
        $client = $event->client;

        Amo::setAccount($client);

        $amo_webhook = new  WebhookModel();
        $amo_webhook->setCreatedBy($client->id);
        $amo_webhook->setDestination(config("amocrm.widget.webhook_url", route('amocrm.webhook', [
            'client_api_key' => "some_api_key",
            // ставим сюда api_key для клиента, и обноволяем его каждый день по крону. также ставим сообитие на обновление вебхука в AmoCRM.
        ])));
        $amo_webhook->setSettings([
            'add_lead',
            'update_lead',
            'add_contact',
            'update_contact',
        ]);

        try {
            $result = Amo::entities()->webhookApi()->sync($amo_webhook, $client->embedded->used_webhook_id);

            $client->embedded->used_webhook_id = $result->getId();

            $client->save();
        } catch (AmoCRMMissedTokenException|AmoCRMoAuthApiException|AmoCRMApiException $e) {
            alt_log()->file('error_amocrm')->error(
                "Не удалось подписаться на вебхук для клиента {$event->client->domain}".json_encode([
                    'message' => $e->getMessage(),
                    'error' => $e->getDescription(),
                ])
            );
        }
    }
}
