<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Airline extends Model
{
    protected $guarded = [];
    use HasFactory;
    use SoftDeletes;

    public function cities() : BelongsToMany
    {
        return $this->belongsToMany(City:: class, 'airline_city', 'airline_id', 'city_id');
    }

    public function flights() : HasMany
    {
        return $this->hasMany(Flight::class, 'airline_id');
    }

    public function active_flights()
    {
        $today = Carbon::now();
        $flights = $this->flights()
                            ->whereDate('departure_date', '<=', $today)
                            ->whereDate('arrival_date', '>=', $today)
                            ->get();

        return $flights;
    }
}
