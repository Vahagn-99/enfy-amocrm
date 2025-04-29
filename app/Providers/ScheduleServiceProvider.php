<?php

namespace App\Providers;

use Illuminate\Console\Scheduling\Schedule as BaseSchedule;
use App\Console\Scheduler;
use Illuminate\Support\ServiceProvider;

class ScheduleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register() : void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot() : void
    {
        /** @var \App\Console\Scheduler $schedule_service */
        $schedule_service = resolve(Scheduler::class);

        $schedule_service->run(app(BaseSchedule::class));
    }
}
