<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTenantRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
             'company_name' => [
                'required', 'string', 'max:255',
            ], 'name' => [
                'required', 'string', 'max:255',
            ], 'plan' => [
                'required',
            ], 'email' => [
                'required', 'email', 'max:255', 'unique:tenants',
            ], 'mobile_number' => [
                'required', 'size:10',
            ], 'source' => [

            ], 'google_recaptcha' => [
                'nullable', 'string',
            ],
        ];
    }
}
