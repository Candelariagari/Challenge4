<?php

namespace Tests\Feature;

use Carbon\Carbon;
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
        $this->airline = Airline::factory()->create();
        $this->originCity = City::factory()->create();
        $this->destinationCity = City::factory()->create();
        $this->airline->cities()->sync([$this->originCity->id, $this->destinationCity->id]);

        $date = Carbon::today()->addDay();
        $depDate = $date->format('Y-m-d H:i:s');
        $arrival_date = $date->addDays(3)->format('Y-m-d H:i:s');

        $this->flight = Flight::create([
            'airline_id' => $this->airline->id,
            'departure_date' => $depDate,
            'origin_id' => $this->originCity->id,
            'arrival_date' => $arrival_date,
            'destination_id' => $this->destinationCity->id
        ]);
    }

    public function test_updates_correctly_flight(): void
    {
        $newAirline = Airline::factory()->create();
        $newAirline->cities()->sync([$this->originCity->id, $this->destinationCity->id]);
        $date = Carbon::today()->addDays(2);
        $depDate = $date->format('Y-m-d H:i:s');
        $arrival_date = $date->addDays(4)->format('Y-m-d H:i:s');

        $updatedAttributes = [
            'airline_id' => $newAirline->id,
            'departure_date' => $depDate,
            'origin_id' => $this->originCity->id,
            'arrival_date' => $arrival_date,
            'destination_id' => $this->destinationCity->id
        ];

        $response = $this->putJson("/api/flights/{$this->flight->id}", $updatedAttributes);
        $response->assertOk();
        $this->assertDatabaseHas('flights', [
            'airline_id' =>  $newAirline->id,
        ]);
    }

    public function test_doesnt_update_flight_with_departure_date_after_arrival_date(): void
    {
        $date = Carbon::today()->addDay();
        $arrival_date = $date->format('Y-m-d H:i:s');
        $dep_date = $date->addDays(3)->format('Y-m-d H:i:s');

        $updatedAttributes = [
            'airline_id' => $this->airline->id,
            'departure_date' => $dep_date,
            'origin_id' => $this->originCity->id,
            'arrival_date' => $arrival_date,
            'destination_id' => $this->destinationCity->id
        ];

        $response = $this->putJson("/api/flights/{$this->flight->id}", $updatedAttributes);
        $response->assertUnprocessable();
    }

    public function test_doesnt_updates_flight_with_airline_that_isnt_related_to_cities(): void
    {
        $date = Carbon::today()->addDay();
        $dep_date = $date->format('Y-m-d H:i:s');
        $arrival_date = $date->addDays(3)->format('Y-m-d H:i:s');

        $newAirline = Airline::factory()->create();
        $updatedAttributes = [
            'airline_id' => $newAirline->id,
            'departure_date' => $dep_date,
            'origin_id' => $this->originCity->id,
            'arrival_date' => $arrival_date,
            'destination_id' => $this->destinationCity->id
        ];

        $response = $this->putJson("/api/flights/{$this->flight->id}", $updatedAttributes);
        $response->assertUnprocessable();
    }
}
