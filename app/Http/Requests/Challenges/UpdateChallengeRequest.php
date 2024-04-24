<?php

namespace App\Http\Requests\Challenges;

use Illuminate\Foundation\Http\FormRequest;

class UpdateChallengeRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => [
                'string',
                'max:255',
                'min:3',
            ],
            'description' => [
                'string',
            ],
            'difficulty' => [
                'integer',
                'min:3',
            ],
            'user_id' => [
                'integer',
                'exists:users,id'
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
