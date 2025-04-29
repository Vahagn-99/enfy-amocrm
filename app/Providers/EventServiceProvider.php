<?php

namespace App\Providers;

use App\Base\Client\Events\AmoAccountAuthenticated;
use App\Base\Client\Listeners\HandleWebhook;
use App\Base\Client\Listeners\SubscribeToAccountWebhooks;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The subscriber classes to register.
     *
     * @var array<class-string>
     */
    protected $subscribe = [
        HandleWebhook::class,
    ];

    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<class-string>>
     */
    protected $listen = [
        AmoAccountAuthenticated::class => [
            SubscribeToAccountWebhooks::class,
        ]
    ];

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents() : bool
    {
        return false;
    }
}
