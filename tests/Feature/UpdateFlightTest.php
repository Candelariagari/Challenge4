<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\City;
use App\Models\Flight;
use App\Models\Airline;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateFlightTest extends TestCase
{
    use RefreshDatabase;

    private $airline;
    private $originCity;
    private $destinationCity;
    private $flight;

    public function setUp(): void
    {
        parent::setUp();
        $this->airline = Airline::create(['id' => 1, 'name' => 'Iberia', 'description' => 'Great airline.']);
        $this->originCity = City::create(['id' => 1, 'name' => 'Montevideo']);
        $this->destinationCity = City::create(['id' => 2, 'name' => 'Miami']);

        $this->airline->cities()->sync([$this->originCity->id, $this->destinationCity->id]);

        $this->flight = Flight::create([
            'id' => 1,
            'airline_id' => $this->airline->id,
            'departure_date' => '2023-11-10 09:10:13',
            'origin_id' => $this->originCity->id,
            'arrival_date' => '2023-11-10 12:10:13',
            'destination_id' => $this->destinationCity->id
        ]);
    }

    public function test_updates_correctly_flight(): void
    {
        $newAirline = Airline::create(['id' => 2, 'name' => 'Copa', 'description' => 'Panama airline']);
        $newAirline->cities()->sync([$this->originCity->id, $this->destinationCity->id]);
        $updatedAttributes = ['id' => 1,
            'airline_id' => $newAirline->id,
            'departure_date' => '2023-11-10 09:10:13',
            'origin_id' => $this->originCity->id,
            'arrival_date' => '2023-11-10 12:10:13',
            'destination_id' => $this->destinationCity->id
        ];

        $response = $this->putJson('/api/flights/1', $updatedAttributes);
        $response->assertOk();
        $response->assertJson([
            'success' => 'Flight updated succesfully.'
        ]);
    }

    public function test_doesnt_update_flight_with_departure_date_after_arrival_date(): void
    {
        $updatedAttributes = ['id' => 1,
            'airline_id' => $this->airline->id,
            'departure_date' => '2023-11-12 09:10:13',
            'origin_id' => $this->originCity->id,
            'arrival_date' => '2023-11-10 12:10:13',
            'destination_id' => $this->destinationCity->id
        ];

        $response = $this->putJson('/api/flights/1', $updatedAttributes);
        $response->assertUnprocessable();
    }

    public function test_doesnt_updates_flight_with_airline_that_isnt_related_to_cities(): void
    {
        $newAirline = Airline::create(['id' => 2, 'name' => 'Copa', 'description' => 'Panama airline']);
        $updatedAttributes = ['id' => 1,
            'airline_id' => $newAirline->id,
            'departure_date' => '2023-11-10 09:10:13',
            'origin_id' => $this->originCity->id,
            'arrival_date' => '2023-11-10 12:10:13',
            'destination_id' => $this->destinationCity->id
        ];

        $response = $this->putJson('/api/flights/1', $updatedAttributes);
        $response->assertUnprocessable();
    }
}
