<?php

namespace App\Filters\Orders;

use App\Filters\Filter;

class SearchFilter extends Filter
{

    protected function shouldApply(): bool{
        return request()->filled('search');
    }
    protected function apply(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder{

        if(request()->filled('search')){
            
            return $query->where('order_number','like','%'.request()->input('search').'%');
        }
        return $query;
    }
}