<?php
namespace App\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

abstract class Filter
{
    public function handle(Builder $query, Closure $next): Builder
    {
        if (!$this->shouldApply()) {
            return $next($query);
        }

        $query = $this->apply($query);

        return $next($query);
    }

    abstract protected function apply(Builder $query): Builder;

    abstract protected function shouldApply(): bool;

    protected function input(string $key, $default = null)
    {
        return request()->input($key, $default);
    }
}
