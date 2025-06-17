<?php

namespace App\Models\Relations;

use App\Models\Team;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait FixtureRelation
{
    public function homeTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    public function opponentTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'opponent_team_id');
    }
}
