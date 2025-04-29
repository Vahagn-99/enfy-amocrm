<?php

namespace App\Base\Client\Events;

use App\Models\Client;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AmoAccountAuthenticated
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @param Client $client
     */
    public function __construct(
        public Client $client,
    ) {
        //
    }
}
