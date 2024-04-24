<?php

namespace App\Http\Requests\Challenges;

use Illuminate\Foundation\Http\FormRequest;

class CreateChallengeRequest extends FormRequest
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
                'required',
                'string',
                'max:255',
                'min:3',
            ],
            'description' => [
                'required',
                'string',
            ],
            'difficulty' => [
                'required',
                'integer',
                'min:3',
            ],
            'user_id' => [
                'required',
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
