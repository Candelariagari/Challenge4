<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function formatted_date($direction)
    {
        $date = $direction == 'departure_date' ? $this->departure_date : $this->arrival_date;
        return Carbon::parse($date)->format('H:i d-m-Y');
    }
}
