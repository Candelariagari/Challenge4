<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\City;
use App\Models\Flight;
use App\Models\Airline;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteFlightTest extends TestCase
{
    use RefreshDatabase;


    public function test_deletes_correctly_given_flight(): void
    {
        $airline = Airline::create(['id' => 1, 'name' => 'Iberia', 'description' => 'Great airline.']);
        $originCity = City::create(['id' => 1, 'name' => 'Montevideo']);
        $destinationCity = City::create(['id' => 2, 'name' => 'Miami']);

        $airline->cities()->sync([$originCity->id, $destinationCity->id]);

        Flight::create([
            'id' => 1,
            'airline_id' => $airline->id,
            'departure_date' => '2023-11-10 09:10:13',
            'origin_id' => $originCity->id,
            'arrival_date' => '2023-11-10 12:10:13',
            'destination_id' => $destinationCity->id
        ]);

        $response = $this->deleteJson('/api/flights/1');
        $response->assertOk();
        $response->assertJson([
            'success' => 'Flight deleted.'
        ]);
    }

    public function test_error_when_deleting_flight_that_doesnt_exists(): void
    {
        $response = $this->deleteJson('/api/flights/2');
        $response->assertNotFound();
    }
}
