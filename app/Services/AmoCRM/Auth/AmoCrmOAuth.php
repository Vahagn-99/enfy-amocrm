<?php

namespace App\Services\AmoCRM\Auth;

use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\OAuth\OAuthServiceInterface;
use League\OAuth2\Client\Token\AccessTokenInterface;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Exceptions\AmoCRMMissedTokenException;
use AmoCRM\Exceptions\AmoCRMoAuthApiException;

class AmoCrmOAuth implements OAuthInterface
{
    const AUTH_MODE_POST_MESSAGE_TYPE = 'post_message';

    /**
     * AmoCrmAuthManager constructor.
     *
     * @param AmoCRMApiClient $apiClient
     * @param \AmoCRM\OAuth\OAuthServiceInterface $auth_service
     */
    public function __construct(
        private readonly AmoCRMApiClient $apiClient,
        private readonly OAuthServiceInterface $auth_service,
    ) {
        //
    }

    /**
     * Получение ссылки для авторизации.
     *
     * @return string
     */
    public function url() : string
    {
        return $this->apiClient->getOAuthClient()->getAuthorizeUrl([
            'mode' => self::AUTH_MODE_POST_MESSAGE_TYPE,
            'state' => config('app.name'),
        ]);
    }

    /**
     * Обмен кода на токен.
     *
     * @throws AmoCRMoAuthApiException
     */
    public function exchangeCodeWithAccessToken(string $code) : AccessTokenInterface
    {
        $oauth = $this->apiClient->getOAuthClient();

        $accessToken = $oauth->getAccessTokenByCode($code);

        if ($accessToken->hasExpired()) {
            $accessToken = $oauth->getAccessTokenByRefreshToken($accessToken);
        }

        return $accessToken;
    }

    /**
     * Статус авторизации.
     *
     * @return boolean
     */
    public function isAuthorized() : bool
    {
        try {
            $this->apiClient->account()->getCurrent();

            return true;
        } catch (AmoCRMoAuthApiException|AmoCRMMissedTokenException|AmoCRMApiException $e) {
            return false;
        }
    }

    /**
     * Сервис авторизации
     *
     * @return \AmoCRM\OAuth\OAuthServiceInterface
     */
    public function oauth(): OAuthServiceInterface
    {
        return $this->auth_service;
    }
}
