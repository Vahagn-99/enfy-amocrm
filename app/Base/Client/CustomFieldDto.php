<?php

declare(strict_types=1);


namespace App\Base\Client;

use Spatie\LaravelData\Data;

class CustomFieldDto extends Data
{
    /**
     * @param int $id
     * @param string $name
     * @param mixed $value
     * @param string|null $code
     * @param int|null $enum
     * @param string $entity
     */
    public function __construct(
        public int $id,
        public string $name,
        public mixed $value,
        public ?string $code = null,
        public ?int $enum = null,
        public string $entity = 'leads',
    ) {
        //
    }
}
