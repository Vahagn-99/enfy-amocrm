<?php

namespace App\Services\AmoCRM\Entities;

use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Helpers\EntityTypesInterface;
use AmoCRM\Models\NoteModel;
use App\Services\AmoCRM\Core\Facades\Amo;

class NoteApi
{
    /**
     * NoteApi constructor
     *
     * @param \AmoCRM\Client\AmoCRMApiClient $apiClient
     */
    public function __construct(
        private readonly AmoCRMApiClient $apiClient,
    ) {
        //
    }

    /**
     * Создать заметку.
     *
     * @param \AmoCRM\Models\NoteModel $note
     * @param string $entityType
     * @return \AmoCRM\Models\NoteModel
     *
     * @throws \AmoCRM\Exceptions\AmoCRMApiException
     * @throws \AmoCRM\Exceptions\AmoCRMMissedTokenException
     * @throws \AmoCRM\Exceptions\AmoCRMoAuthApiException
     * @throws \AmoCRM\Exceptions\InvalidArgumentException
     */
    public function notify(NoteModel $note, string $entityType = EntityTypesInterface::LEADS) : NoteModel
    {
        $api = $this->apiClient->notes($entityType);

        return $api->addOne($note);
    }
}
