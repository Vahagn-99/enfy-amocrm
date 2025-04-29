<?php

namespace App\Base\Client;

use App\Base\Client\CustomFieldDto as CustomFieldDto;

final class  CustomFieldHandler
{
    public static function mapFromArrayOfCustomFields(array $fields, string $entity = 'leads') : array
    {
        $handled = [];

        foreach ($fields as $field) {
            $handledField = (new CustomFieldHandler)->mapField($field, $entity);

            if ($handledField !== null) {
                $handled[] = $handledField;
            }
        }

        return $handled;
    }

    private function mapField(array $customField, string $entity) : ?CustomFieldDto
    {
        $value = $this->extractValue($customField);

        if ($value) {
            return CustomFieldDto::from([
                'id' => intval($customField['field_id'] ?? $customField['id']),
                'name' => $customField['field_name'] ?? $customField['name'],
                'code' => $customField['field_code'] ?? $customField['code'] ?? null,
                'value' => $value,
                'entity' => $entity,
                'enum' => current($customField['values'])['enum'] ?? null,
            ]);
        }

        return null;
    }

    private function extractValue(array $customField) : mixed
    {
        if (count($customField['values']) > 1) {
            return implode(', ', array_map(fn($item) => is_array($item) ? ($item['value'] ?? null) : $item, $customField['values']));
        }

        $firstValue = current($customField['values']);

        return is_array($firstValue) ? ($firstValue['value'] ?? null) : $firstValue;
    }
}
