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
                'required', 'string',
            ],
            'addressable_id' => [
                'required', 'integer',
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
