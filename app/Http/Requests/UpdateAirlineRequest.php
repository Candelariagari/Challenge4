<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAirlineRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $airline = $this->route('airline');

        return [
            'name' => ['required', Rule::unique('airlines', 'name')->ignore($airline->id)],
            'description' => 'required',
            'cities' => ['nullable', 'array'],
            'cities.*' => [Rule::exists('cities', 'id')]
        ];
    }

    public function toArray(): array
    {
        return ['name' => (string) $this->string('name'),
                'description' => (string) $this->string('description'),
                'cities' => $this->input('cities', [])
        ];
    }
}
