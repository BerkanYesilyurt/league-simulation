<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class LeagueStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'week' => [
                'required',
                'integer',
                'min:1',
                'max:6'
            ],
            'all' => [
                'required',
                'boolean'
            ]
        ];
    }
}
