<?php

namespace App\Services\AmoCRM\Entities;

class Entities implements EntitiesInterface
{
    /**
     * @param \App\Services\AmoCRM\Entities\NoteApi $note_api
     * @param \App\Services\AmoCRM\Entities\WebhookApi $webhook_api
     */
    public function __construct(
        public readonly NoteApi $note_api,
        public readonly WebhookApi $webhook_api,
    ) {
        //
    }

    /**
     * Апи сервис для работы с заметками
     *
     * @return \App\Services\AmoCRM\Entities\NoteApi
     */
    public function noteApi() : NoteApi
    {
        return $this->note_api;
    }

    /**
     * Апи сервис для работы с вебхуками
     *
     * @return \App\Services\AmoCRM\Entities\WebhookApi
     */
    public function webhookApi() : WebhookApi
    {
        return $this->webhook_api;
    }
}