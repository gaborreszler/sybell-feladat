<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFrequencyScheduleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() || $this->expectsJson();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'frequency' => ['filled', 'string', 'max:255'],
            'schedule' => ['filled', 'string', 'max:255', 'regex:/^(\*|[0-9,-\/\*]+\s){4}[0-9,-\/\*]+$/'],
        ];
    }
}
