<?php

declare(strict_types=1);

namespace App\Base\Client;

use AmoCRM\Models\WebhookModel;
use Spatie\LaravelData\Data;

class CreateWebhook extends Data
{
    /**
     * Create a new instance.
     *
     * @param string $id
     * @param string $destination
     * @param int $created_by
     * @param array $settings
     * @param int $account_id
     * @param int $created_at
     * @param int $updated_at
     * @param int $sort
     * @param bool $disabled
     */
    public function __construct(
        public readonly string $id,
        public readonly string $destination,
        public readonly int $created_by,
        public readonly int $account_id,
        public readonly int $created_at,
        public readonly int $updated_at,
        public readonly int $sort,
        public readonly array $settings = [],
        public readonly bool $disabled = false,
    ) {
        //
    }

    /**
     * Создание экземпляра из модели AmoCRM.
     *
     * @param \AmoCRM\Models\WebhookModel $model
     * @return static
     */
    public static function fromAmoModel(WebhookModel $model) : CreateWebhook
    {
        return new self(
            id : $model->getId(),
            destination : $model->getDestination(),
            created_by : $model->getCreatedBy(),
            account_id : $model->getAccountId(),
            created_at : $model->getCreatedAt(),
            updated_at : $model->getUpdatedAt(),
            sort : $model->getSort(),
            settings : $model->getSettings(),
            disabled : $model->getDisabled(),
        );
    }
}
