<?php

declare(strict_types=1);


namespace App\Base\Client;

class EventReconizer
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
        $events = config('amocrm.webhooks.support');

        if (isset($events[$entity][$action])) {
            return $events[$entity][$action];
        }

        return null;
    }
}
