<?php

namespace App\Filters\Permissions;

use App\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class SearchFilter extends Filter{

    public function shouldApply(): bool{
        return request()->filled('search');
    }

    public function apply(Builder $query):Builder{
        $search = request()->input('search');
        return $query->where('name','like','%'.$search.'%');
    }

}