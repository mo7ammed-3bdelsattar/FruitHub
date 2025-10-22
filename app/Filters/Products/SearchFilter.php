<?php


namespace App\Filters\Products;

use App\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class SearchFilter extends Filter{

     protected function shouldApply(): bool
    {
        return request()->filled('search');
    }

    protected function apply(Builder $query): Builder
    {
        $search = $this->input('search');

        return $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%")
              ->orWhereHas('category', fn($query) => 
                  $query->where('name', 'like', "%{$search}%")
              )
              ->orWhereHas('tags', fn($query) => 
                  $query->where('name', 'like', "%{$search}%")
              );
        });
    }

}