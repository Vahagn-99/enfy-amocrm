<?php

declare(strict_types=1);

use App\Base\Client\Events\{
    ContactCreated as ContactCreatedEvent,
    ContactUpdated as ContactUpdatedEvent,
    LeadCreated as LeadCreatedEvent,
    LeadUpdated as LeadUpdatedEvent,
};

return [
    /*
    |--------------------------------------------------------------------------
    | Данные интеграции
    |--------------------------------------------------------------------------
    |
    */
    "widget" => [
        "client_id" => env("AMOCRM_CLIENT_ID"),
        "client_secret" => env("AMOCRM_CLIENT_SECRET"),
        // Но лучше его а оставить null
        // ностаяий аддрес для редиректа берется по роуту route("amocrm.auth.callback") в сервис провайдере AmoCRMServiceProvider
        "redirect_url" => env("AMOCRM_REDIRECT_URL"), // route("amocrm.auth.callback")
        "webhook_url" => env("AMOCRM_WEBHOOK_URL"), // route("amocrm.webhook")
    ],

    /*
    |--------------------------------------------------------------------------
    | Настройки вебхуков
    |--------------------------------------------------------------------------
    |
    */
    "webhooks" => [
        "support" => ["leads", "contacts"],
        "event" => [
            "leads" => [
                "add" => LeadCreatedEvent::class,
                "update" => LeadUpdatedEvent::class,
            ],
            "contacts" => [
                "add" => ContactCreatedEvent::class,
                "update" => ContactUpdatedEvent::class,
            ],
            "templates" => [
                "leads" => [
                    "add" => "Название сделки: %s \n Ответственный: %s \n Дата создания: %s",
                    "update" => "Название сделки: %s \n изменные поля: %s \n Дата обновления: %s",
                ],
                "contacts" => [
                    "add" => "Имя контакта: %s \n Ответственный: %s \n  Дата создания: %s",
                    "update" => "Имя контакта: %s \n изменные поля: %s \n Дата обновления: %s",
                ],
            ],
        ],
    ],
];
