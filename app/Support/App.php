<?php

declare(strict_types=1);


namespace App\Support;

class App extends \App
{
    public static function isDev(): bool
    {
        return config('app.dev_mode_enabled');
    }
}
