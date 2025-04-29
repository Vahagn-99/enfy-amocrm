<?php

namespace App\Services\AmoCRM\Auth;


use AmoCRM\Exceptions\AmoCRMoAuthApiException;
use AmoCRM\OAuth\OAuthServiceInterface;
use League\OAuth2\Client\Token\AccessTokenInterface;

interface OAuthInterface
{
    const AUTH_MODE_POST_MESSAGE_TYPE = 'post_message';

    /**
     * Получение ссылки для авторизации.
     *
     * @return string
     */
    public function url() : string;

    /**
     * Обмен кода на токен.
     *
     * @throws AmoCRMoAuthApiException
     */
    public function exchangeCodeWithAccessToken(string $code) : AccessTokenInterface;

    /**
     * Статус авторизации.
     *
     * @return boolean
     */
    public function isAuthorized() : bool;

    /**
     * Сервис авторизации
     *
     * @return OAuthServiceInterface
     */
    public function oauth(): OAuthServiceInterface;
}
