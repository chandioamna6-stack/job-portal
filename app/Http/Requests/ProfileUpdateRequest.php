<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            // Only validate if the field exists in the request
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => [
                'sometimes',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],

            // Extra fields optional
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:100'],
            'bank_name' => ['nullable', 'string', 'max:150'],
            'account_number' => ['nullable', 'string', 'max:50'],
            'avatar' => ['nullable', 'image', 'max:2048'], // profile picture
        ];
    }
}
