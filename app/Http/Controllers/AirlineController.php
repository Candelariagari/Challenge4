<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Airline;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use App\Http\Requests\StoreAirlineRequest;
use App\Http\Requests\UpdateAirlineRequest;

class AirlineController extends Controller
{
    public function index() : View
    {
        return view('airlines.show', [
            'airlines' => Airline::paginate(5)
        ]);
    }

    public function store(StoreAirlineRequest $request) : JsonResponse
    {
        $newAirline = Airline::create($request->toArray());
        return response()->json($newAirline);
    }

    public function delete(Airline $airline) : JsonResponse
    {
        $airline->delete();
        return response()->json([
            'success' => 'Airline has been deleted.'
        ]);
    }

    public function edit(Airline $airline) : View
    {
        $cities = City::all();

        $selectedCities = $airline->load('cities');

        return view('airlines.updateForm', [
            'airline' => $airline,
            'cities' => $cities,
            'selectedCities' => $selectedCities
        ]);
    }

    public function update(UpdateAirlineRequest $request, Airline $airline) : JsonResponse
    {
        $requestAttributes = $request->toArray();
        $airline->update(['name' => $requestAttributes["name"],
                         'description' => $requestAttributes["description"]]);
        $airline->cities()->sync($requestAttributes["cities"]);

        return response()->json([
            'success'=>'Airline updated!'
        ]);
    }

    public function all(): JsonResponse
    {
        $airlines = Airline::with('cities')->get();
        return response()->json($airlines);
    }

    // public function citiesOfAirline(Airline $airline): JsonResponse
    // {
    //     $cities = $airline->cities;
    //     return response()->json($cities);
    // }
}
