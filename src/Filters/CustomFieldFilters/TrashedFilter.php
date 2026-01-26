<?php

namespace CustomFields\LaravelCustomFields\Filters\CustomFieldFilters;

use CustomFields\LaravelCustomFields\Filters\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

class TrashedFilter implements FilterInterface
{
    public static function apply(Builder $builder, $value): Builder
    {
        if ($value === 'only') {
            return $builder->onlyTrashed();
        }

        return $builder;
    }
}
