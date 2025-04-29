<?php

namespace App\Base\Client\Listeners;


use App\Base\Client\CustomFieldDto;
use App\Base\Client\Events\{
    ContactCreated,
    ContactUpdated,
    LeadCreated,
    LeadUpdated,
};
use App\Services\AmoCRM\Core\Facades\Amo;
use Carbon\Carbon;
use AmoCRM\Models\NoteModel;
use AmoCRM\Models\NoteType\CommonNote;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use AmoCRM\Exceptions\AmoCRMApiException;
use Spatie\LaravelData\DataCollection;

class HandleWebhook implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Обработка хука при создании лида.
     *
     * @param \App\Base\Client\Events\LeadCreated $event
     * @return void
     */
    public function handleLeadCreated(LeadCreated $event) : void
    {
        $client = $event->client;

        Amo::setAccount($client);

        $webhook = $event->webhook;

        $text = sprintf($this->getTemplate($webhook->entity, $webhook->action),
            $webhook->entity_name,
            $webhook->responsible_user_id,
            Carbon::createFromTimestamp($webhook->created_at)->toDateTimeString()
        );

        try {
            $this->send($webhook->entity_id, $text);
        } catch (AmoCRMApiException $e) {
            alt_log()->file('error_handle_webhook')->error("Не удалось добавить заметку на созданном сделке.", [
                "domain" => $client->domain,
                "error" => $e->getDescription(),
                "error_message" => $e->getMessage(),
                "webhook" => $webhook->toArray(),
            ]);
        }
    }

    /**
     * Обработка хука при обновлении лида.
     *
     * @param \App\Base\Client\Events\LeadCreated $event
     * @return void
     */
    public function handleLeadUpdated(LeadCreated $event) : void
    {
        $client = $event->client;

        Amo::setAccount($client);

        $webhook = $event->webhook;

        $changed_custom_fields_imploded = $this->chainCustomFields($webhook->entity_custom_fields);

        $text = sprintf($this->getTemplate($webhook->entity, $webhook->action),
            $webhook->entity_name,
            $changed_custom_fields_imploded,
            Carbon::createFromTimestamp($webhook->updated_at)->toDateTimeString()
        );

        try {
            $this->send($webhook->entity_id, $text);
        } catch (AmoCRMApiException $e) {
            alt_log()->file('error_handle_webhook')->error("Не удалось добавить заметку на обновленном сделке.", [
                "domain" => $client->domain,
                "error" => $e->getDescription(),
                "error_message" => $e->getMessage(),
                "webhook" => $webhook->toArray(),
            ]);
        }
    }

    /**
     * Обработка хука при создании контакта.
     *
     * @param \App\Base\Client\Events\ContactCreated $event
     * @return void
     */
    public function handleContactCreated(ContactCreated $event) : void
    {
        $client = $event->client;

        Amo::setAccount($client);

        $webhook = $event->webhook;

        $text = sprintf($this->getTemplate($webhook->entity, $webhook->action),
            $webhook->entity_name,
            $webhook->responsible_user_id,
            Carbon::createFromTimestamp($webhook->created_at)->toDateTimeString()
        );

        try {
            $this->send($webhook->entity_id, $text);
        } catch (AmoCRMApiException $e) {
            alt_log()->file('error_handle_webhook')->error("Не удалось добавить заметку на созданном контакте.", [
                "domain" => $client->domain,
                "error" => $e->getDescription(),
                "error_message" => $e->getMessage(),
                "webhook" => $webhook->toArray(),
            ]);
        }
    }

    /**
     * Обработка хука при обновлении контакта.
     *
     * @param \App\Base\Client\Events\ContactUpdated $event
     * @return void
     */
    public function handleContactUpdated(ContactUpdated $event) : void
    {
        $client = $event->client;

        Amo::setAccount($client);

        $webhook = $event->webhook;

        $changed_custom_fields_imploded = $this->chainCustomFields($webhook->entity_custom_fields);

        $text = sprintf($this->getTemplate($webhook->entity, $webhook->action),
            $webhook->entity_name,
            $changed_custom_fields_imploded,
            Carbon::createFromTimestamp($webhook->updated_at)->toDateTimeString()
        );

        try {
            $this->send($webhook->entity_id, $text);
        } catch (AmoCRMApiException $e) {
            alt_log()->file('error_handle_webhook')->error("Не удалось добавить заметку на обновленном контакте.", [
                "domain" => $client->domain,
                "error" => $e->getDescription(),
                "error_message" => $e->getMessage(),
                "webhook" => $webhook->toArray(),
            ]);
        }
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @return array<string, string>
     */
    public function subscribe() : array
    {
        return [
            LeadCreated::class => 'handleLeadCreated',
            LeadUpdated::class => 'handleLeadUpdated',
            ContactCreated::class => 'notify',
            ContactUpdated::class => 'handleContactUpdated',
        ];
    }

    //****************************************************************
    //************************** Support *****************************
    //****************************************************************

    /**
     * Отправка заметк  в AmoCRM.
     *
     * @param int $entity_id
     * @param string $text
     * @param int|null $note_id
     * @return \AmoCRM\Models\NoteModel
     *
     * @throws \AmoCRM\Exceptions\AmoCRMApiException
     * @throws \AmoCRM\Exceptions\AmoCRMMissedTokenException
     * @throws \AmoCRM\Exceptions\AmoCRMoAuthApiException
     * @throws \AmoCRM\Exceptions\InvalidArgumentException
     */
    private function send(int $entity_id, string $text, int $note_id = null) : NoteModel
    {
        $note = new CommonNote();

        $note->setEntityId($entity_id)->setText($text);

        if (! empty($note_id)) {
            $note->setId($note_id);
        }

        return Amo::noteApi()->notify($note);
    }

    /**
     * Получить шаблона заметки по событию.
     *
     * @param string $entity
     * @param string $action
     * @return string
     */
    private function getTemplate(string $entity, string $action) : string
    {
        return config("amocrm.webhooks.event.templates.{$entity}.{$action}");
    }

    /**
     * Преобразовать кастомные поля в строку.
     *
     * @param \Spatie\LaravelData\DataCollection $custom_fields
     * @return string
     */
    private function chainCustomFields(DataCollection $custom_fields) : string
    {
        return implode(", ", $custom_fields->toCollection()->map(fn(CustomFieldDto $field) => $field->name.": ".$field->value)->toArray());
    }
}
