<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ActiveFlights implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        $builder->withCount(['flights as active_flights' =>
            fn ($query) => $query->whereDate('departure_date', '<=', now())
                                 ->whereDate('arrival_date', '>=', now())
        ]);
    }
}
