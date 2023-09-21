<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreFlightRequest;
use App\Http\Requests\UpdateFlightRequest;
use App\Models\Airline;
use Illuminate\View\View;

class FlightController extends Controller
{
    public function index(): View
    {
        return view('flights.show', [
            'flights' => Flight::paginate(10)
        ]);
    }
    public function store(StoreFlightRequest $request): JsonResponse
    {
        $newflight = Flight::create($request->toArray());

        return response()->json($newflight);
    }

    public function delete(Flight $flight) : JsonResponse
    {
        $flight->delete();
        return response()->json([
            'success' => 'Flight deleted.'
        ]);
    }

    public function update(UpdateFlightRequest $request, Flight $flight)
    {
        $updatedFlight = $flight->update($request->toArray());

        return response()->json($updatedFlight);
    }
}
