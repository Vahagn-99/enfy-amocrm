<?php

namespace App\Providers;

use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Client\AmoCRMApiClientFactory;
use AmoCRM\OAuth\OAuthServiceInterface;
use App\Services\AmoCRM\Auth\AmoCrmOAuth;
use App\Services\AmoCRM\Auth\OauthConfig;
use App\Services\AmoCRM\Auth\OAuthInterface;
use App\Services\AmoCRM\Auth\SaveOnDatabase;
use App\Services\AmoCRM\Core\Manager\AmoManager;
use App\Services\AmoCRM\Entities\Entities;
use App\Services\AmoCRM\Entities\EntitiesInterface;
use Illuminate\Support\ServiceProvider;

class AmoCRMServiceProvider extends ServiceProvider
{
    public function register() : void
    {
        $this->app->singleton(OAuthServiceInterface::class, SaveOnDatabase::class);
        $this->app->singleton(AmoCRMApiClient::class, function () {
            $config = new OauthConfig(
                config('amocrm.widget.client_id'),
                config('amocrm.widget.client_secret'),
                config('amocrm.widget.redirect_url', route('amocrm.oauth.callback')),
            );

            $oauth_service = resolve(OAuthServiceInterface::class);

            $factory = new AmoCRMApiClientFactory($config, $oauth_service);

            return $factory->make();
        });
        $this->app->singleton(EntitiesInterface::class, Entities::class);
        $this->app->singleton(OAuthInterface::class, AmoCrmOAuth::class);

        $this->app->singleton('amocrm', AmoManager::class);
    }
}
