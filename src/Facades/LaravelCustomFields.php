<?php

namespace CustomFields\LaravelCustomFields\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \CustomFields\LaravelCustomFields\LaravelCustomFields
 */
class LaravelCustomFields extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return LaravelCustomFields::class;
    }
}
