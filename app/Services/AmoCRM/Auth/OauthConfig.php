<?php

declare(strict_types=1);

namespace App\Services\AmoCRM\Auth;

use AmoCRM\OAuth\OAuthConfigInterface;

readonly class OauthConfig implements OAuthConfigInterface
{
    /**
     * OauthConfig constructor.
     *
     * @param string $integrationId
     * @param string $secretKey
     * @param string $redirectUrl
     */
    public function __construct(
        private string $integrationId,
        private string $secretKey,
        private string $redirectUrl,
    ) {
    }

    /**
     * Идентификатор интеграции
     *
     * @return string
     */
    public function getIntegrationId(): string
    {
        return $this->integrationId;
    }

    /**
     * Секретный ключ
     *
     * @return string
     */
    public function getSecretKey(): string
    {
        return $this->secretKey;
    }

    /**
     * URL для перенаправления
     *
     * @return string
     */
    public function getRedirectDomain(): string
    {
        return $this->redirectUrl;
    }
}
