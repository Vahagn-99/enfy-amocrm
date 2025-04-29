<?php

declare(strict_types=1);

namespace App\Base\Client;

use Spatie\LaravelData\Data;

class AccessToken extends Data
{
    /**
     * Create a new instance.
     *
     * @param string $access_token
     * @param string $refresh_token
     * @param string $expires
     */
    public function __construct(
        public readonly string $access_token,
        public readonly string $refresh_token,
        public readonly string $expires,
    ) {
        //
    }

    /**
     * Получить токен доступа.
     *
     * @return \League\OAuth2\Client\Token\AccessToken
     */
    public function getAmoAccessToken(): \League\OAuth2\Client\Token\AccessToken
    {
        return new \League\OAuth2\Client\Token\AccessToken([
            'access_token' => $this->access_token,
            'refresh_token' => $this->refresh_token,
            'expires' => $this->expires,
        ]);
    }
}
