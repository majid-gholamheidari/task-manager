<?php

namespace App\Http\Requests\Api\V1\Board;

use Illuminate\Foundation\Http\FormRequest;

class SaveBoardRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

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
                'max:250',
            ],
            'description' => [
                'nullable',
            ],
            'status' => [
                'required',
                'in:active,inactive',
            ]
        ];
    }
}
