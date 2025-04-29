<?php

declare(strict_types=1);

namespace App\Services\AmoCRM\Auth;

use AmoCRM\OAuth\OAuthServiceInterface;
use App\Base\Client\AccessToken;
use App\Models\Client;
use Exception;
use League\OAuth2\Client\Token\AccessTokenInterface;

class SaveOnDatabase implements OAuthServiceInterface
{
    /**
     * Сохранить токен доступа.
     *
     * @inheritDoc
     * @throws \Exception
     */
    public function saveOAuthToken(AccessTokenInterface $accessToken, string $baseDomain) : void
    {
        $client = Client::getByDomain($baseDomain);

        if (! $client) {
            throw new Exception('Клиент по домену {$baseDomain} не найден');
        }

        $client->access_token = AccessToken::from([
            'access_token' => $accessToken->getToken(),
            'refresh_token' => $accessToken->getRefreshToken(),
            'expires' => $accessToken->getExpires(),
        ]);

        $client->save();
    }
}
