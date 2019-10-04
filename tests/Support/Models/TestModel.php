<?php

namespace OwowAgency\LaravelResources\Tests\Support\Models;

use Illuminate\Database\Eloquent\Model;

class TestModel extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'value',
    ];
}
