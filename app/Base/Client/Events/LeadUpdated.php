<?php

namespace App\Base\Client\Events;

use App\Base\Client\HttpIncomingWebhook;
use App\Models\Client;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LeadUpdated
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\Client $client
     * @param \App\Base\Client\HttpIncomingWebhook $webhook
     */
    public function __construct(
        public readonly Client $client,
        public readonly HttpIncomingWebhook $webhook,
    ) {
        //
    }
}
