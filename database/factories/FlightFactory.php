<?php

namespace Database\Factories;

use App\Models\Airline;
use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Flight>
 */
class FlightFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'airline_id' => Airline::factory()->create()->id,
            'departure_date' => $this->faker->dateTimeBetween('+1 day', '+1 year'),
            'origin_id' => City::factory()->create()->id,
            'arrival_date' => $this->faker->dateTimeBetween('+2 day', '+1 year'),
            'destination_id' => City::factory()->create()->id,
        ];
    }
}
