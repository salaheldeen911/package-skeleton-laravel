<?php

namespace Salah\LaravelCustomFields\Filters\CustomFieldFilters;

use Illuminate\Database\Eloquent\Builder;
use Salah\LaravelCustomFields\Filters\FilterInterface;

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
