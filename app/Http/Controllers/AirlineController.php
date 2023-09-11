<?php

namespace App\Http\Controllers;

use App\Models\Airline;
use Illuminate\Http\Request;
use App\Http\Requests\StoreOrUpdateAirlineRequest;

class AirlineController extends Controller
{
    public function index()
    {
        return view('airlines.show', [
            'airlines' => Airline::paginate(5)
        ]);
    }

    public function store(StoreOrUpdateAirlineRequest $request)
    {
        Airline::create($request->toArray());
        return response()->json([
            'success' => 'Airline created succesffully.'
        ]);
    }

    public function delete(Airline $airline){
        $airline->delete();
        return response()->json([
            'success' => 'Airline has been deleted.'
        ]);
    }

    public function edit(Airline $airline)
    {
        // return response()->json($airline);
        return view('airlines.updateForm', [
            'airline' => $airline
        ]);
    }

    public function update(StoreOrUpdateAirlineRequest $request, Airline $airline)
    {
        $airline->update($request->toArray());
        return response()->json([
            'success'=>'Airline updated!'
        ]);
    }
}
