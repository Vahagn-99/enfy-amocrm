<?php

namespace App\Services\AmoCRM\Core\Facades;

use App\Services\AmoCRM\Auth\OAuthInterface;
use App\Services\AmoCRM\Core\Client\IAmoAccount;
use App\Services\AmoCRM\Core\Manager\AmoManager;
use App\Services\AmoCRM\Entities\EntitiesInterface;
use Illuminate\Support\Facades\Facade;

/**
 * @method static AmoManager setAccount(IAmoAccount $account)
 * @method static OAuthInterface authenticator()
 * @method static EntitiesInterface entities()
 *
 * @see AmoManager
 * @mixin OAuthInterface
 */
class Amo extends Facade
{
    /**
     * Фасад для работы с AmoCRM
     *
     * @return string
     */
    protected static function getFacadeAccessor() : string
    {
        return 'amocrm';
    }
}