<?php

namespace App\Services;

use App\Enums\MatchStatus;
use App\Models\Fixture;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class GameService
{
    public function playGamesAndGetFixture(int $week = 1, bool $all = false): Collection
    {
        foreach($this->getFixture($week, $all) as $fixture) {
            $homeTeamStats = $fixture->homeTeam->stats;
            $opponentTeamStats = $fixture->opponentTeam->stats;

            DB::transaction(function () use ($fixture, $homeTeamStats, $opponentTeamStats) {
                $fixture->update([
                    'home_team_score' => $homeScore = $this->generateScoreByStrength($homeTeamStats->strength),
                    'opponent_team_score' => $opponentScore = $this->generateScoreByStrength($opponentTeamStats->strength),
                    'status' => MatchStatus::PLAYED
                ]);

                $this->processMatchResult($homeScore, $homeTeamStats, $opponentScore, $opponentTeamStats);
            });
        }

        return $this->getFixture($week, false);
    }

    private function generateScoreByStrength($value): int
    {
        return rand(0, floor($value * 10));
    }

    private function getFixture($week, $all): Collection
    {
        return Fixture::with(['homeTeam.stats', 'opponentTeam.stats'])
            ->when(!$all, fn($query) => $query->where('week', $week))
            ->get();
    }

    private function processMatchResult($homeScore, $homeStats, $opponentScore, $opponentStats): void
    {
        $result = match (true) {
            $homeScore > $opponentScore => 'home',
            $homeScore < $opponentScore => 'opponent',
            default => 'draw',
        };

        if ($result === 'draw') {
            $this->updateStats($homeStats, $homeScore, $opponentScore, isWin: false, isDraw: true);
            $this->updateStats($opponentStats, $opponentScore, $homeScore, isWin: false, isDraw: true);
        } elseif ($result === 'home') {
            $this->updateStats($homeStats, $homeScore, $opponentScore, isWin: true);
            $this->updateStats($opponentStats, $opponentScore, $homeScore, isWin: false);
        } else {
            $this->updateStats($opponentStats, $opponentScore, $homeScore, isWin: true);
            $this->updateStats($homeStats, $homeScore, $opponentScore, isWin: false);
        }
    }

    private function updateStats($teamStats, $scored, $conceded, bool $isWin = false, bool $isDraw = false): void
    {
        $teamStats->update([
            'wins' => $teamStats->wins + ($isWin ? 1 : 0),
            'draws' => $teamStats->draws + ($isDraw ? 1 : 0),
            'losses' => $teamStats->losses + (!$isWin && !$isDraw ? 1 : 0),
            'points' => $teamStats->points + ($isWin ? 3 : ($isDraw ? 1 : 0)),
            'goals' => $teamStats->goals + $scored,
            'goals_from_opponents' => $teamStats->goals_from_opponents + $conceded,
            'goal_difference' => $teamStats->goal_difference + ($scored - $conceded),
        ]);
    }
}
