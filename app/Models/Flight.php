<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Flight extends Model
{
    protected $guarded = [];
    use HasFactory;
    use SoftDeletes;

    public function airline() : BelongsTo
    {
        return $this->belongsTo(Airline::class);
    }

    public function origin() : BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function destination() : BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
