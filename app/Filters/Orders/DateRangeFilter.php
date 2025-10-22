<?php 

namespace App\Filters\Orders;

use Carbon\Carbon;
use App\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class DateRangeFilter extends Filter{


    public function shouldApply(): bool{
        return request()->filled('date_range');
    }

    public function apply(Builder $query): Builder{
        
        $range = request()->input('date_range');

        return match($range) {
            'today' => $query->whereDate('created_at', Carbon::today()),
            'yesterday' => $query->whereDate('created_at', Carbon::yesterday()),
            'last_7_days' => $query->where('created_at', '>=', Carbon::now()->subDays(7)),
            'last_30_days' => $query->where('created_at', '>=', Carbon::now()->subDays(30)),
            'last_3_months' => $query->where('created_at', '>=', Carbon::now()->subMonths(3)),
            'last_year' => $query->where('created_at', '>=', Carbon::now()->subYear()),
            default => $query,
        };
    }
}