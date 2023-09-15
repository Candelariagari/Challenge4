<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateFlightRequest extends FormRequest
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
        return [
            'airline_id' => ['required', Rule::exists('airlines', 'id')],
            'departure_date' => ['required', 'date', 'after:today'],
            'origin_id' => ['required', Rule::exists('cities', 'id'), Rule::exists('airline_city', 'city_id')->where('airline_id', $this->input('airline_id'))],
            'arrival_date' => ['required', 'date', 'after:departure_date'],
            'destination_id' => ['required', 'different:origin_id', Rule::exists('cities', 'id'), Rule::exists('airline_city', 'city_id')->where('airline_id', $this->input('airline_id'))]
        ];
    }

    public function toArray(): array
    {
        return ['airline_id' => (integer) $this->integer('airline_id'),
                'departure_date' => $this->input('departure_date'),
                'origin_id' => (integer) $this->integer('origin_id'),
                'arrival_date' => $this->input('arrival_date'),
                'destination_id' => (integer) $this->integer('destination_id'),
        ];
    }

    public function getAirlineId() : int
    {
        return $this->integer('airline_id');
    }

    public function cities() : array
    {
        return [
            'origin_id' => (integer) $this->integer('origin_id'),
            'destination_id' => (integer) $this->integer('destination_id'),
        ];
    }

    public function updatedSchedules()
    {
        return [
            'departure_date' => $this->input('departure_date'),
            'arrival_date' => $this->input('arrival_date')
        ];
    }
}
