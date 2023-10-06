<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class City extends Model
{
    protected $guarded = [];
    use HasFactory;
    use SoftDeletes;

    public function airlines() : BelongsToMany
    {
        return $this->belongsToMany(Airline:: class, 'airline_city', 'city_id', 'airline_id');
    }

    public function flights()
    {
        return $this->belongsToMany(Flight::class);
    }

    public function departures()
    {
        return $this->hasMany(Flight::class, 'origin_id');
    }

    public function arrivals()
    {
        return $this->hasMany(Flight::class, 'destination_id');
    }

}
