<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateBankRequest extends FormRequest
{

    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'bankable_id' => [
                'required', 'integer',
            ], 'bankable_type' => [
                'required', 'string',
            ], 'account_name' => [
                'required',
            ], 'account_number' => [
                'required',
            ], 'ifsc_code' => [
                'required',
            ], 'branch_name' => [
                'nullable',
            ], 'bank_name' => [
                'required',
            ],
        ];
    }
}
