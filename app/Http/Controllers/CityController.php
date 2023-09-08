<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Requests\StoreOrUpdateCityRequest;
use Illuminate\Http\JsonResponse;

class CityController extends Controller
{
    public function index()
    {
        return view('cities.show', [
            'cities' => City::paginate(10)
        ]);
    }

    public function store(StoreOrUpdateCityRequest $request)
    {
        $newCity = City::create($request->toArray());
        return response()->json($newCity);
    }

    public function delete(City $city)
    {
        $city->delete();
        return response()->json([
            'success' => 'City has been deleted.'
        ]);
    }

    public function edit(City $city)
    {
        return view('cities.updateForm', ['city' => $city]);
    }

    public function update(City $city, StoreOrUpdateCityRequest $request)
    {
        $city->update($request->toArray());
        return response()->json([
            'success'=>'City updated!'
        ]);
    }
}
