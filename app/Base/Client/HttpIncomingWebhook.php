<?php

declare(strict_types=1);

namespace App\Base\Client;

use Arr;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Exception;

class HttpIncomingWebhook extends Data
{
    /**
     * @param int $entity_id
     * @param string $entity_name
     * @param \Spatie\LaravelData\DataCollection $entity_custom_fields
     * @param string $action
     * @param string $entity
     * @param int $responsible_user_id
     * @param string $created_at
     * @param string|null $updated_at
     */
    public function __construct(
        public int $entity_id,
        public string $entity_name,
        public DataCollection $entity_custom_fields,
        public string $action,
        public string $entity,
        public int $responsible_user_id,
        public string $created_at,
        public ?string $updated_at = null,
    ) {
        //
    }

    /**
     * Создает экземпляр из данных хука.
     *
     * @param array $data
     * @return \App\Base\Client\HttpIncomingWebhook
     *
     * @throws \Exception
     */
    public static function fromRequestData(array $data) : static
    {
        foreach (config("amocrm.webhooks.support") as $entity) {
            if (Arr::has($data, $entity)) {

                $action = key($data[$entity]);

                $data = current(current($data[$entity]));

                $custom_fields = isset($data['custom_fields']) ? CustomFieldHandler::mapFromArrayOfCustomFields($data['custom_fields']): [];

                return new static(
                    entity_id : (int)$data['id'],
                    entity_name : $data['name'] ?? 'Без имени #'.$data['id'],
                    entity_custom_fields : new DataCollection(CustomFieldDto::class, $custom_fields),
                    action : $action,
                    entity : $entity,
                    responsible_user_id : isset($data['responsible_user_id']) ? (int)$data['responsible_user_id'] : 0,
                    created_at : $data['created_at'],
                    updated_at : $data['updated_at'] ?? null,
                );
            }
        }

        throw new Exception('Данный Вебхук не поддерживается: '.json_encode($data));
    }
}
