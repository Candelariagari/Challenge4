<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use App\Http\Requests\UpsertFlightRequest;

class FlightController extends Controller
{
    public function index(): View
    {
        return view('flights.show', [
            'flights' => Flight::paginate(10)
        ]);
    }

    public function store(UpsertFlightRequest $request): JsonResponse
    {
        $newflight = Flight::create($request->toArray());
        $newflight->load(['origin', 'destination']);

        return response()->json($newflight);
    }

    public function delete(Flight $flight) : JsonResponse
    {
        $flight->delete();
        return response()->json([
            'success' => 'Flight deleted.'
        ]);
    }

    public function edit(Flight $flight): View
    {
        return view('flights.updateForm', ['flight' => $flight]);
    }

    public function update(UpsertFlightRequest $request, Flight $flight): JsonResponse
    {
        $updatedFlight = $flight->update($request->toArray());

        return response()->json($updatedFlight);
    }
}
