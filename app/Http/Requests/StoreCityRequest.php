<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCityRequest extends FormRequest
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
        //dd($this->input());
        return [
            'name' => ['required', 'string', 'max:255'],
            'frequency_schedule' => ['nullable', 'integer', 'exists:frequency_schedules,id', 'exclude_unless:frequency_schedule_custom,null'],
            'frequency_schedule_custom' => ['nullable', 'required_if:frequency_schedule,null', 'string', 'max:255', 'regex:/^(\*|[0-9,-\/\*]+\s){4}[0-9,-\/\*]+$/'],
        ];
    }
}
