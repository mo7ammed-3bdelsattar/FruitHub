<?php

namespace App\Filters\Products;

use App\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class PriceFilter extends Filter{


    protected function shouldApply(): bool{
        return request()->filled('minPrice') || request()->filled('maxPrice');
    }

    protected function apply(Builder $query):Builder{
        if(request()->filled('minPrice') && request()->filled('maxPrice')){
            return $query->whereBetween('price',[$this->input('minPrice'),$this->input('maxPrice')]);
        }
        
        elseif(request()->filled('minPrice')){
            return $query->where('price','>=',$this->input('minPrice'));
        }
        elseif(request()->filled('maxPrice')){
            return $query->where('price','<=',$this->input('maxPrice'));
        }
        return $query;
    }


}