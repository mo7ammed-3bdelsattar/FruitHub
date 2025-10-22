<?php

namespace App\Filters\Orders;

use App\Filters\Filter;

class StatusFilter extends Filter{
     
    public function shouldApply(): bool{
        return request()->filled('status');
    }

    public function apply(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder{
        $status = request()->input('status');
        return $query->where('status',$status);
    }
}