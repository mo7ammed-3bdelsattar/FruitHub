<?php

namespace App\Filters\Products;

use App\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class TagFilter extends Filter{


    protected function shouldApply(): bool{
        return request()->filled('tagId');
    }

    protected function apply(Builder $query):Builder{
        if(request()->filled('tagId')){
            return $query->whereHas('tags',fn($q) =>
            $q->where('tags.id',$this->input('tagId'))
        );
        }
        return $query;
    }


}