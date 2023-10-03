<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Flight;
use App\Models\Airline;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use App\Http\Requests\StoreFlightRequest;
use Illuminate\Contracts\Session\Session;
use App\Http\Requests\UpdateFlightRequest;

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

    public function update(UpdateFlightRequest $request, Flight $flight): JsonResponse
    {
        $updatedFlight = $flight->update($request->toArray());

        return response()->json($updatedFlight);
    }
}
