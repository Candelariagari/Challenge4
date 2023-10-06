<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\City;
use App\Models\Airline;
use Carbon\Carbon;
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

        $this->airline = Airline::factory()->create();
        $this->originCity = City::factory()->create();
        $this->destinationCity = City::factory()->create();
    }

    public function testStoresCorrectlyNewFlight(): void
    {
        $this->airline->cities()->sync([$this->originCity->id, $this->destinationCity->id]);
        $date = Carbon::today()->addDay();
        $depDate = $date->format('Y-m-d H:i:s');
        $arrival_date = $date->addDays(3)->format('Y-m-d H:i:s');

        $newFlightAttributes = [
            'airline_id' => $this->airline->id,
            'departure_date' => $depDate,
            'origin_id' => $this->originCity->id,
            'arrival_date' =>  $arrival_date,
            'destination_id' => $this->destinationCity->id
        ];

        $response = $this->postJson('/api/flights', $newFlightAttributes);
        $this->assertDatabaseHas('flights', $newFlightAttributes);
        $response->assertOk();
    }

    public function test_doesnt_stores_flight_with_airline_that_doesnt_operates_in_depcity(): void
    {
        $this->airline->cities()->sync([$this->originCity->id]);
        $date = Carbon::today()->addDay();
        $depDate = $date->format('Y-m-d H:i:s');
        $arrival_date = $date->addDays(3)->format('Y-m-d H:i:s');

        $newFlightAttributes = [
            'airline_id' => $this->airline->id,
            'departure_date' => $depDate,
            'origin_id' => $this->originCity->id,
            'arrival_date' => $arrival_date,
            'destination_id' => $this->destinationCity->id
        ];

        $response = $this->postJson('/api/flights', $newFlightAttributes);

        $response->assertUnprocessable();
    }

    public function test_doesnt_stores_flight_with_same_departurecity_and_arrivalcity(): void
    {
        $this->airline->cities()->sync([$this->originCity->id]);
        $date = Carbon::today()->addDay();
        $depDate = $date->format('Y-m-d H:i:s');
        $arrival_date = $date->addDays(3)->format('Y-m-d H:i:s');

        $newFlightAttributes = [
            'airline_id' => $this->airline->id,
            'departure_date' => $depDate,
            'origin_id' => $this->originCity->id,
            'arrival_date' => $arrival_date,
            'destination_id' => $this->originCity->id
        ];

        $response = $this->postJson('/api/flights', $newFlightAttributes);

        $response->assertUnprocessable();
    }

    public function test_doesnt_stores_flight_with_arrivalDate_before_depDate(): void
    {
        $this->airline->cities()->sync([$this->originCity->id, $this->destinationCity->id]);
        $date = Carbon::today()->addDay();
        $arrival_date = $date->format('Y-m-d H:i:s');
        $depDate = $date->addDays(3)->format('Y-m-d H:i:s');

        $newFlightAttributes = [
            'airline_id' => $this->airline->id,
            'departure_date' => $depDate,
            'origin_id' => $this->originCity->id,
            'arrival_date' => $arrival_date,
            'destination_id' => $this->destinationCity->id
        ];

        $response = $this->postJson('/api/flights', $newFlightAttributes);

        $response->assertUnprocessable();
    }
}
