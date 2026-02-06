<?php

namespace Salah\LaravelCustomFields\Tests\Support\Models;

use Illuminate\Database\Eloquent\Model;
use Salah\LaravelCustomFields\Traits\HasCustomFields;

class Post extends Model
{
    use HasCustomFields;

    protected $guarded = [];
}
