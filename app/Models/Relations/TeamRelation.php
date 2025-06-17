<?php

namespace App\Models\Relations;

use App\Models\TeamStat;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait TeamRelation
{
    public function stats(): HasOne
    {
        return $this->hasOne(TeamStat::class);
    }
}
