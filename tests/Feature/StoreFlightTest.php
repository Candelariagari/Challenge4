<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\City;
use App\Models\Airline;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreFlightTest extends TestCase
{
    use RefreshDatabase;

    private $airline;
    private $originCity;
    private $destinationCity;

    public function setUp(): void
    {
        parent::setUp();

        $this->airline = Airline::create(['id' => 1, 'name' => 'Iberia', 'description' => 'Great airline.']);
        $this->originCity = City::create(['id' => 1, 'name' => 'Montevideo']);
        $this->destinationCity = City::create(['id' => 2, 'name' => 'Miami']);
    }

    public function testStoresCorrectlyNewFlight(): void
    {
        $this->airline->cities()->sync([$this->originCity->id, $this->destinationCity->id]);

        $newFlightAttributes = [
            'airline_id' => $this->airline->id,
            'departure_date' => '2023-11-10 09:10:13',
            'origin_id' => $this->originCity->id,
            'arrival_date' => '2023-11-10 12:10:13',
            'destination_id' => $this->destinationCity->id
        ];

        $response = $this->postJson('/api/flights', $newFlightAttributes);
        $this->assertDatabaseHas('flights', $newFlightAttributes);
        $response->assertOk();
    }

    public function test_doesnt_stores_flight_with_airline_that_doesnt_operates_in_depcity(): void
    {
        $this->airline->cities()->sync([$this->originCity->id]);

        $newFlightAttributes = [
            'airline_id' => $this->airline->id,
            'departure_date' => '2023-11-10 09:10:13',
            'origin_id' => $this->originCity->id,
            'arrival_date' => '2023-11-10 12:10:13',
            'destination_id' => $this->destinationCity->id
        ];

        $response = $this->postJson('/api/flights', $newFlightAttributes);

        $response->assertUnprocessable();
    }

    public function test_doesnt_stores_flight_with_same_departurecity_and_arrivalcity(): void
    {
        $this->airline->cities()->sync([$this->originCity->id]);

        $newFlightAttributes = [
            'airline_id' => $this->airline->id,
            'departure_date' => '2023-11-10 09:10:13',
            'origin_id' => $this->originCity->id,
            'arrival_date' => '2023-11-10 12:10:13',
            'destination_id' => $this->originCity->id
        ];

        $response = $this->postJson('/api/flights', $newFlightAttributes);

        $response->assertUnprocessable();
    }

    public function test_doesnt_stores_flight_with_arrivalDate_before_depDate(): void
    {
        $this->airline->cities()->sync([$this->originCity->id, $this->destinationCity->id]);

        $newFlightAttributes = [
            'airline_id' => $this->airline->id,
            'departure_date' => '2023-11-10 12:10:13',
            'origin_id' => $this->originCity->id,
            'arrival_date' => '2023-11-10 09:10:13',
            'destination_id' => $this->destinationCity->id
        ];

        $response = $this->postJson('/api/flights', $newFlightAttributes);

        $response->assertUnprocessable();
    }
}
