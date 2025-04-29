<?php

namespace App\Services\AmoCRM\Entities;

interface EntitiesInterface
{
    /**
     * Апи сервис для работы с заметками
     *
     * @return \App\Services\AmoCRM\Entities\NoteApi
     */
    public function noteApi() : NoteApi;

    /**
     * Апи сервис для работы с вебхуками
     *
     * @return \App\Services\AmoCRM\Entities\WebhookApi
     */
    public function webhookApi() : WebhookApi;
}