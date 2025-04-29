<?php

use App\Services\Logger\AltLog;

if (! function_exists('alt_log')) {
    function alt_log() : AltLog
    {
        return new AltLog();
    }
}
