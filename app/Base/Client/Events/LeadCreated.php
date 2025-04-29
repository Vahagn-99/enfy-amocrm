<?php

namespace App\Base\Client\Events;

use App\Models\Client;
use App\Base\Client\HttpIncomingWebhook;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LeadCreated
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event client.
     *
     * @param \App\Models\Client $client
     * @param \App\Base\Client\HttpIncomingWebhook $webhook
     */
    public function __construct(
        public readonly Client $client,
        public readonly HttpIncomingWebhook $webhook,
    )
    {
        //
    }
}
