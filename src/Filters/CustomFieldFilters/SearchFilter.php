<?php

namespace Salah\LaravelCustomFields\Filters\CustomFieldFilters;

use Illuminate\Database\Eloquent\Builder;
use Salah\LaravelCustomFields\Filters\FilterInterface;

class SearchFilter implements FilterInterface
{
    public static function apply(Builder $builder, $value): Builder
    {
        return $builder->where('name', 'like', '%'.$value.'%');
    }
}
