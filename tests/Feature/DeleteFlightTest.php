<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Flight;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteFlightTest extends TestCase
{
    use RefreshDatabase;

    public function test_deletes_correctly_given_flight(): void
    {
        $flight = Flight::factory()->create();
        $this->deleteJson("/api/flights/{$flight->id}");
        $this->assertSoftDeleted($flight);
    }

    public function test_error_when_deleting_flight_that_doesnt_exists(): void
    {
        $response = $this->deleteJson('/api/flights/2');
        $response->assertNotFound();
    }
}
