<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CallbackRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'code' => ['required', 'string'],
            'referer' => ['required', 'string'],
            'state'=> ['nullable', 'string'],
        ];
    }
}
