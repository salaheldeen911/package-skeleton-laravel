<?php

namespace CustomFields\LaravelCustomFields\Filters\CustomFieldFilters;

use CustomFields\LaravelCustomFields\Filters\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

class TypeFilter implements FilterInterface
{
    public static function apply(Builder $builder, $value): Builder
    {
        return $builder->where('type', $value);
    }
}
