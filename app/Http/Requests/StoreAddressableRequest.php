<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreAddressableRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }


    public function rules(): array
    {
        return [
            'address_line' => [
                'nullable', 'string',
            ],
            'city' => [
                'nullable', 'string',
            ],
            'state' => [
                'nullable', 'string',
            ],
            'zip_code' => [
                'nullable', 'integer',
            ],
        ];
    }
}
