<?php

namespace App\Services;

use App\Models\Fixture;
use App\Models\TeamStat;
use Illuminate\Support\Facades\DB;

class ResetService
{
    public function reset(): void
    {
        DB::transaction(function () {
            Fixture::query()->update([
                'home_team_score' => NULL,
                'opponent_team_score' => NULL,
                'status' => 0
            ]);

            TeamStat::query()->update([
                'wins' => 0,
                'draws' => 0,
                'losses' => 0,
                'points' => 0,
                'goals' => 0,
                'goals_from_opponents' => 0,
                'goal_difference' => 0
            ]);
        });
    }
}
