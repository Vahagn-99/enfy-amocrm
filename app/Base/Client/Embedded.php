<?php

declare(strict_types=1);

namespace App\Base\Client;

use Spatie\LaravelData\Data;

class Embedded extends Data
{
    /**
     * Create a new instance.
     *
     * @param int|null $used_webhook_id
     */
    public function __construct(
        public readonly ?int $used_webhook_id = null,
    ) {
        //
    }
}
