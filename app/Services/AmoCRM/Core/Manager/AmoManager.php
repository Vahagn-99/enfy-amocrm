<?php

namespace App\Services\AmoCRM\Core\Manager;

use AmoCRM\Client\AmoCRMApiClient;
use App\Services\AmoCRM\Auth\OAuthInterface;
use App\Services\AmoCRM\Core\Client\IAmoAccount;
use App\Services\AmoCRM\Entities\EntitiesInterface;

readonly class AmoManager
{
    /**
     * AmoManager constructor.
     *
     * @param AmoCRMApiClient $api_client
     * @param OAuthInterface $auth_manager
     * @param \App\Services\AmoCRM\Entities\EntitiesInterface $entities
     */
    public function __construct(
        private AmoCRMApiClient $api_client,
        private OAuthInterface $auth_manager,
        private EntitiesInterface $entities,
    )
    {
        //
    }

    /**
     * Аутентификатор
     *
     * @return OAuthInterface
     */
    public function authenticator() : OAuthInterface
    {
        return $this->auth_manager;
    }

    /**
     * Установка аккаунта
     *
     * @param \App\Services\AmoCRM\Core\Client\IAmoAccount $account
     * @return static
     */
    public function setAccount(IAmoAccount $account) : static
    {
        $this->api_client->setAccountBaseDomain($account->getDomain());

        $accessToken = $account->getAccessToken();

        if (isset($accessToken)) {
            $this->api_client->setAccessToken($accessToken);
        }

        return $this;
    }

    /**
     * Апи сервиси
     *
     * @return \App\Services\AmoCRM\Entities\EntitiesInterface
     */
    public function entities() : EntitiesInterface
    {
        return $this->entities;
    }
}