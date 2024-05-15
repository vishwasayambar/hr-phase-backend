<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountActivationTokenVerificationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'token' => [
                'required',
                'exists:verification_codes,code',
            ],
        ];
    }
}
