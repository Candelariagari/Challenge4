<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AirlineCity extends Model
{
    protected $guarded = [];
    use HasFactory;
    use SoftDeletes;

    protected $table = 'airline_city';

}
