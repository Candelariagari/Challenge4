<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model
{
    protected $guarded = [];
    use HasFactory;
    use SoftDeletes;

    public function airlines()
    {
        return $this->hasMany(Airline::class);
    }

    public function depatures()
    {
        return $this->hasMany(Flight::class, 'origin_id');
    }

    public function arrivals()
    {
        return $this->hasMany(Flight::class, 'destination_id');
    }
}
