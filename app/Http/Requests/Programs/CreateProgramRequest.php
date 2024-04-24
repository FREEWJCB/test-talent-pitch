<?php

namespace App\Http\Requests\Programs;

use App\Enums\ProgramEntityType;
use App\Rules\Rules\ExistEntityRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateProgramRequest extends FormRequest
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
            'start_date' => [
                'required',
                'date',
            ],
            'end_date' => [
                'required',
                'date',
            ],
            'user_id' => [
                'required',
                'integer',
                'exists:users,id'
            ],
            'entities' => [
                'array',
                ExistEntityRule::class
            ],
            'entities.*.id' => [
                'required',
                'integer',
            ],
            'entities.*.type' => [
                'required',
                'string',
                'max:255',
                'min:3',
                Rule::enum(ProgramEntityType::class)
            ],
        ];
    }
}