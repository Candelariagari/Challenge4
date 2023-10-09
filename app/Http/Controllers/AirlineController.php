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
    public function index(Request $request) : View
    {
        $airlines =  Airline::paginate(5);

        if ($request->has('city')){
            $city = City::with('airlines')->find($request->input('city'));
            $airlines_cities = $city->airlines()->paginate(5);
            if(!$request->has('active_flights')){
                $airlines = $airlines_cities;
            }
        }

        if($request->has('active_flights')){
            $airlines_active_flights = Airline::withCount(['flights as active_flights' =>
                fn ($query) => $query->whereDate('departure_date', '<=', now())
                                    ->whereDate('arrival_date', '>=', now())
                ])
            ->havingRaw('active_flights = ?', [$request->input('active_flights')])
            ->paginate(5);
            if(!$request->input('city')){
                $airlines = $airlines_active_flights;
            }
        }

        if($request->has('city') && $request->has('active_flights')){
            $airlines = $airlines_cities->intersect($airlines_active_flights);
            if($airlines->count() > 0){
                $airlines = $airlines->toQuery()->paginate(5);
            }
        }

        return view('airlines.show', [
            'airlines' => $airlines,
            'cities' => City::all()
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
}
