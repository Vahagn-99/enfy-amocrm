<?php

namespace App\Providers;

use App\Base\Client\Listeners\HandleWebhook;
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
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents() : bool
    {
        return false;
    }
}
