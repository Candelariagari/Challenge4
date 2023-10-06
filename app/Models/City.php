<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Flight;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    protected $guarded = [];
    use HasFactory;
    use SoftDeletes;

    public function airlines() : BelongsToMany
    {
        return $this->belongsToMany(Airline:: class, 'airline_city', 'city_id', 'airline_id');
    }

    public function flights() : BelongsToMany
    {
        return $this->belongsToMany(Flight::class);
    }

    public function departures(): HasMany
    {
        return $this->hasMany(Flight::class, 'origin_id');
    }

    public function arrivals(): HasMany
    {
        return $this->hasMany(Flight::class, 'destination_id');
    }

}
