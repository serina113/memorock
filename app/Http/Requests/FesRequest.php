<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'fes_name' => 'required|string|max:100',
            'hashtag' => 'required|string|max:50',
            'body' => 'required|string|max:1000',
        ];
    }
}
