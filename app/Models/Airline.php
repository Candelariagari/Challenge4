<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
}
