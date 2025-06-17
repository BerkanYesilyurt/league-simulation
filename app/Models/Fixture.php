<?php

namespace App\Models;

use App\Models\Relations\FixtureRelation;
use Illuminate\Database\Eloquent\Model;

class Fixture extends Model
{
    use FixtureRelation;

    protected $guarded = ['id'];
    public $timestamps = false;
}
