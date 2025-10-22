<?php

namespace App\Filters\Products;

use App\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class CategoryFilter extends Filter{


    protected function shouldApply(): bool{
        return request()->filled('categoryId');
    }

    protected function apply(Builder $query):Builder{
        if(request()->filled('categoryId')){
            return $query->where('category_id',$this->input('categoryId'));
        }
        return $query;
    }


}