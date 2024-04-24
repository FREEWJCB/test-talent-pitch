<?php

namespace App\Http\Requests\Companies;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'string',
                'max:255',
                'min:3',
            ],
            'location' => [
                'string',
                'max:255',
                'min:3',
            ],
            'industry' => [
                'string',
                'max:255',
                'min:3',
            ],
            'user_id' => [
                'integer',
                'exists:users,id'
            ],
            'image_path' => [
                'string',
                'max:255',
            ],
            'programs' => [
                'array',
            ],
            'programs.*' => [
                'integer',
                'exists:programs,id'
            ],
        ];
    }
}
