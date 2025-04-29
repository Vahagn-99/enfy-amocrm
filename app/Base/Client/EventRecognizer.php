<?php

declare(strict_types=1);


namespace App\Base\Client;

class EventRecognizer
{
    /**
     * Получение события по сущности и действию.
     *
     * @param string $entity
     * @param string $action
     * @return string|null
     */
    public static function getEvent(string $entity, string $action): ?string
    {
        return config("amocrm.webhooks.event.{$entity}.{$action}");
    }
}
