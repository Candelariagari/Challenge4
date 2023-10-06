<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Airline;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use App\Http\Requests\StoreOrUpdateCityRequest;

class CityController extends Controller
{
    public function index(Request $request) : View
    {
        $airlines = Airline::all();

        if($request->has('order_by') && !$request->has('airline')){
            return view('cities.show', [
                'cities' => City::orderBy($request->input('order_by'), $request->input('order_by') == 'name' ? 'asc' : 'desc')->paginate(10),
                'airlines' => $airlines
            ]);
        }

        if($request->has('airline')){
            $airlineId = $request->input('airline');
            $airline = Airline::with('cities')->find($airlineId);
            $cities = $airline->cities();

            if($request->has('order_by')){
                $cities = $cities->orderBy($request->input('order_by'), $request->input('order_by') == 'name' ? 'asc' : 'desc');
            }

            $cities = $cities->paginate(10);
            return view('cities.show', [
                'cities' => $cities,
                'airlines' => $airlines
            ]);
        }
        return view('cities.show', [
            'cities' => City::paginate(10),
            'airlines' => $airlines
        ]);
    }

    public function store(StoreOrUpdateCityRequest $request) : JsonResponse
    {
        $newCity = City::create($request->toArray());
        return response()->json($newCity);
    }

    public function delete(City $city) : JsonResponse
    {
        $city->delete();
        return response()->json([
            'success' => 'City has been deleted.'
        ]);
    }

    public function edit(City $city) : View
    {
        return view('cities.updateForm', ['city' => $city]);
    }

    public function update(City $city, StoreOrUpdateCityRequest $request) : JsonResponse
    {
        $city->update($request->toArray());
        return response()->json($city);
    }

    public function all(): JsonResponse
    {
        $cities = City::all();
        return response()->json($cities);
    }

    public function getAirlines(City $city): JsonResponse
    {
        $airlines = $city->airlines;
        return response()->json($airlines);
    }
}
