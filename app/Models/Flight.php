<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Flight extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];
    protected $casts = [
        'departure_date' => 'datetime:H:i d-m-Y',
        'arrival_date' => 'datetime:H:i d-m-Y',
    ];

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
