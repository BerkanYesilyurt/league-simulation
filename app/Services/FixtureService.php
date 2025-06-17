<?php

namespace App\Services;

use App\Models\Fixture;
use App\Models\Team;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class FixtureService
{
    public function createFixture(int $totalWeeks = 6): void
    {
        if(Fixture::count() == 0){
            DB::transaction(function () use ($totalWeeks)
            {
                $teams = Team::pluck('id')->shuffle()->values()->toArray();
                $teamCount = count($teams);
                $half = $teamCount / 2;

                for ($week = 1; $week <= $totalWeeks; $week++) {
                    for ($match = 0; $match < $half; $match++) {
                        $homeIndex = ($week + $match) % ($teamCount - 1);
                        $opponentIndex = ($teamCount - 1 - $match + $week) % ($teamCount - 1);

                        if ($match == 0) {
                            $opponentIndex = $teamCount - 1;
                        }

                        $home = $teams[$homeIndex];
                        $opponent = $teams[$opponentIndex];

                        if ($week <= $totalWeeks / 2) {
                            $homeTeamId = $home;
                            $opponentTeamId = $opponent;
                        } else {
                            $homeTeamId = $opponent;
                            $opponentTeamId = $home;
                        }

                        Fixture::create([
                            'week' => $week,
                            'home_team_id' => $homeTeamId,
                            'opponent_team_id' => $opponentTeamId,
                        ]);
                    }
                }
            });
        }
    }
}
