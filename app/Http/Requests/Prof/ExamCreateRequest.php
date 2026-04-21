<?php

namespace App\Http\Requests\Prof;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ExamCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'about' => ['nullable', 'string'],
            'close_date' => ['required', 'date', 'after_or_equal:today'],
            'extensions' => ['nullable', 'array'],
            'extensions.*' => ['exists:file_extensions,id'],
        ];
    }
}
