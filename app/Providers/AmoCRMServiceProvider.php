<?php

namespace App\Providers;

use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Client\AmoCRMApiClientFactory;
use App\Services\AmoCRM\Auth\AmoCrmOAuth;
use App\Services\AmoCRM\Auth\OAuthInterface;
use App\Services\AmoCRM\Auth\OauthConfig;
use App\Services\AmoCRM\Auth\SaveOnDatabase;
use App\Services\AmoCRM\Core\Manager\AmoManager;
use App\Services\AmoCRM\Entities\Entities;
use App\Services\AmoCRM\Entities\EntitiesInterface;
use Illuminate\Support\ServiceProvider;

class AmoCRMServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(AmoCRMApiClient::class, function () {
            $config = new OauthConfig(
                config('amocrm.widget.client_id'),
                config('amocrm.widget.client_secret'),
                route('amocrm.oauth.callback')
            );

            $oauth_service = resolve(SaveOnDatabase::class);

            $factory = new AmoCRMApiClientFactory($config, $oauth_service);

            $factory->make();
        });

        $this->app->singleton(EntitiesInterface::class, Entities::class);
        $this->app->singleton(OAuthInterface::class, AmoCrmOAuth::class);

        $this->app->singleton('amocrm', AmoManager::class);
    }
}
