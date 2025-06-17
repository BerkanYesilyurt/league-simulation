<?php

namespace App\Services;

use App\Models\Fixture;
use Illuminate\Database\Eloquent\Collection;

class PredictionService
{
    public function __construct(public Collection $teams){}

    public function calculateRatios(bool $show = false): array
    {
        if(!$show || !Fixture::where('status', 0)->exists())
            return $this->emptyRatios();

        $scores = [];

        foreach ($this->teams as $team) {
            $score = ($team['stats']['points'] * 20)
                + (($team['stats']['wins'] - $team['losses']) * 2)
                + ($team['stats']['goal_difference'] / 10)
                + ($team['stats']['strength'] * 100);

            $scores[] = [
                'name' => $team['name'],
                'score' => $score
            ];
        }

        $collection = collect($scores);
        $total = $collection->sum('score');
        return $collection->map(function ($team) use ($total) {
            return [
                'name' => $team['name'],
                'chance' => round($team['score'] / $total * 100, 2)
            ];
        })->all();
    }

    private function emptyRatios(): array
    {
        $champId = !Fixture::where('status', 0)->exists() ? $this->teams
            ->pluck('stats')
            ->flatten()
            ->sortByDesc(fn($stat) => [$stat->points, $stat->goal_difference])
            ->first()?->id : NULL;

        return $this->teams->map(function ($team) use ($champId){
            return [
                'name' => $team['name'],
                'chance' => ($champId && $team->id == $champId) ? 100 : 0
            ];
        })->all();
    }
}
