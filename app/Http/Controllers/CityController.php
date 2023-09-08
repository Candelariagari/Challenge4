<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Requests\StoreOrUpdateCityRequest;
use Illuminate\Http\JsonResponse;

class CityController extends Controller
{
    public function index() : View
    {
        return view('cities.show', [
            'cities' => City::paginate(10)
        ]);
    }

    public function store(StoreOrUpdateCityRequest $request) : json_decode
    {
        $newCity = City::create($request->toArray());
        return response()->json($newCity);
    }

    public function delete(City $city) : json_decode
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

    public function update(City $city, StoreOrUpdateCityRequest $request) : json_decode
    {
        $city->update($request->toArray());
        return response()->json($city);
    }
}
