<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
{

    public function authorize(): bool
    {
        return false;
    }

    public function rules(): array
    {
        $bankRequest = new UpdateBankRequest();
        $addressRequest = new UpdateAddressableRequest();
        $bankRules = collect($bankRequest->rules())
            ->mapWithKeys(fn ($rules, $field) => ['bank.*.' . $field => $rules])
            ->toArray();
        $addressRules = collect($addressRequest->rules())
            ->mapWithKeys(fn ($rules, $field) => ['address.*.' . $field => $rules])
            ->toArray();

        $employeeRules = [
            'email' => [
                'required',
                //                Rule::unique('users', 'email')
                //                    ->where('type_id', UserType::USER_TYPE_EMPLOYEE),
            ],
            'name' => [
                'required',
                'string',
                'max:60',
            ],
            'display_name' => [
                'nullable',
                'string',
                'max:60',
            ],
            'mobile_number' => [
                'nullable',
                'min:10',
                //                Rule::unique('users', 'mobile_number')
                //                    ->where('type_id', UserType::USER_TYPE_EMPLOYEE),
            ],
            'date_of_birth' => [
                'nullable',
                'date',
            ],
            'unique_identification_number' => [
                'nullable',
                'alpha_num',
                'size:12',
            ],
            'tax_number' => [
                'nullable',
                'alpha_num',
                'size:10',
            ],
            'phone_number' => [
                'nullable',
                'max:20',
            ],
            'gender' => [
                'nullable',
                'in:' . implode(',', ['Male', 'Female', 'Other']),
            ],
            'address' => [
                'array',
            ],
            'bank' => [
                'array',
            ],
            'role_id' => [
                'required',
                //                Rule::notIn([3, 4, 5]),
            ],
        ];

        return [...$employeeRules, ...$addressRules, ...$bankRules];

    }
}
