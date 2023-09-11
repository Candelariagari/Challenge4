<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Airline extends Model
{
    protected $guarded = [];
    use HasFactory;
    use SoftDeletes;

    // public function origin()
}