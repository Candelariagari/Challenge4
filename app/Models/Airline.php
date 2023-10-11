<?php

namespace App\Models;

use App\Models\Scopes\ActiveFlights;
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

    protected static function booted(): void
    {
        parent::boot();
        static::addGlobalScope(new ActiveFlights);
    }
}
