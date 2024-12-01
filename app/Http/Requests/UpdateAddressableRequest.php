<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateAddressableRequest extends FormRequest
{

    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'addressable_type' => [
                'nullable', 'string',
            ],
            'addressable_id' => [
                'nullable', 'integer',
            ],
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
