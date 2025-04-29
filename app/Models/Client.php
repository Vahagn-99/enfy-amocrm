<?php

namespace App\Models;

use App\Base\Client\AccessToken;
use App\Base\Client\Embedded;
use App\Services\AmoCRM\Core\Client\IAmoAccount;
use Illuminate\Foundation\Auth\User as Authenticatable;

final class Client extends Authenticatable implements IAmoAccount
{
    /**
     * Скрытые поля.
     *
     * @var string
     */
    protected $hidden = ['access_token'];

    /**
     * Массив кастов.
     *
     * @var array
     */
    protected $casts = [
        'access_token' => AccessToken::class,
        'embedded' => Embedded::class.":default",
    ];

    /**
     * Получение пользователя по домену.
     *
     * @param string $domain
     * @return \App\Models\Client|null
     */
    public static function getByDomain(string $domain) : ?Client
    {
        /** @var Client $client */
        return Client::where('domain', $domain)->first();
    }

    /**
     * Получение токена доступа.
     *
     * @return \League\OAuth2\Client\Token\AccessToken|null
     */
    public function getAccessToken() : ?\League\OAuth2\Client\Token\AccessToken
    {
        return $this->access_token?->getAmoAccessToken();
    }

    /**
     * Получение домена.
     *
     * @return string
     */
    public function getDomain() : string
    {
        return $this->domain;
    }

    /**
     * Получение идентификатора пользователя.
     *
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }
}
