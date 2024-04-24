<?php

namespace App\Http\Requests\Companies;

use Illuminate\Foundation\Http\FormRequest;

class CreateCompanyRequest extends FormRequest
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
                'required',
                'string',
                'max:255',
                'min:3',
            ],
            'location' => [
                'required',
                'string',
                'max:255',
                'min:3',
            ],
            'industry' => [
                'required',
                'string',
                'max:255',
                'min:3',
            ],
            'user_id' => [
                'required',
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
