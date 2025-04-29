<?php

namespace App\Services\AmoCRM\Entities;

use AmoCRM\Models\NoteModel;
use AmoCRM\Helpers\EntityTypesInterface;
use App\Services\AmoCRM\Core\Facades\Amo;

class NoteApi
{
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
        $api = Amo::client()->notes($entityType);

        return $api->addOne($note);
    }
}
