<?php

use App\Http\Controllers\{
    OAuthController,};
use App\Http\Controllers\WebhookController;
use Illuminate\Support\Facades\Route;

Route::prefix('amocrm')->name("amocrm.")->group(function () {
    Route::get('oauth/login', [OAuthController::class, 'login'])->name('oauth.login');
    Route::post('oauth/callback', [OAuthController::class, 'callback'])->name('oauth.callback');

    Route::prefix('api')->group(function () {
        Route::post('webhook', WebhookController::class)->name('webhook');
    });
});