<?php

namespace App\Http\Requests\Api\V1\Member;

use Illuminate\Foundation\Http\FormRequest;

class AddMemberRequest extends FormRequest
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
            'email' => [
                'required',
                'email',
                'exists:users,email'
            ],
            'access_level' => [
                'required',
                'array',
            ],
            'access_level.*' => [
                'exists:access_levels,title'
            ],
            'expiration' => [
                'nullable',
                'date_format:Y/m/d H:i',
                'after_or_equals:' . now()->format('Y/m/d H:i')
            ]
        ];
    }
}
