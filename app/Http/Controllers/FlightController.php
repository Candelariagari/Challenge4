<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreFlightRequest;
use App\Http\Requests\UpdateFlightRequest;

class FlightController extends Controller
{

    public function store(StoreFlightRequest $request)
    {
        Flight::create($request->toArray());

        return response()->json([
            'success' => 'Flight created succesfully.'
        ]);
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
        $flight->update($request->toArray());

        return response()->json([
            'success' => 'Flight updated succesfully.'
        ]);
    }
}
