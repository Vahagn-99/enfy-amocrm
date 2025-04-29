<?php

namespace App\Services\AmoCRM\Core\Client;

use League\OAuth2\Client\Token\AccessToken;

/**
 * @property int $id
 * @property string $domain
 */
interface IAmoAccount
{
    /**
     * Получить аккаунт по домену
     *
     * @param string $domain
     * @return IAmoAccount|null
     */
    public function getAccessToken(): ?AccessToken;

    /**
     * Сохранить токен доступа
     *
     * @return string
     */
    public function getDomain(): string;

    /**
     * Получить идентификатор аккаунта
     *
     * @return int
     */
    public function getId(): int;
}