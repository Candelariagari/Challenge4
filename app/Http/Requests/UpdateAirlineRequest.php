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
            'name'=> ['required', Rule::unique('airlines', 'name')->where(function ($query) {
                    $query->whereNull('deleted_at');
                })->ignore($airline->id)],
            'description'=> 'required'
        ];
    }
}
