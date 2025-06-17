<?php

namespace App\Http\Controllers;

use App\Models\Fixture;
use App\Models\Team;
use App\Services\PredictionService;

class PredictionController extends Controller
{
    public function index(): array
    {
        $currentWeek = Fixture::where('status', 0)->orderBy('week')->value('week') ?? 6;
        return (new PredictionService(Team::with('stats')->get()))->calculateRatios(($currentWeek >= 4));
    }
}
