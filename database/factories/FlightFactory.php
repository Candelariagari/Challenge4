<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\City;
use App\Models\Airline;
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
            'arrival_date' => fn (array $attributes) => Carbon::parse($attributes['departure_date'])->copy()->addDay()->toDateTimeString(),
            'destination_id' => City::factory()->create()->id,
        ];
    }
}
