<?php

namespace App\Models;

use App\Models\Relations\TeamRelation;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use TeamRelation;

    protected $guarded = ['id'];
    public $timestamps = false;
}
