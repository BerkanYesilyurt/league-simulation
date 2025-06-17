<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamStat extends Model
{
    protected $table = 'team_stats';
    protected $guarded = ['id'];
    public $timestamps = false;
}
