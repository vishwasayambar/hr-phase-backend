<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasRole('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'display_name' => 'required|string|max:255',
            'guard_name' => 'required|string|in:api',
        ];
    }

    protected function prepareForValidation(): void
    {
        // Set a default value for guard_name if not provided
        if (!$this->has('guard_name')) {
            $this->merge([
                'guard_name' => 'api', // Default value
            ]);
        }
    }
}
