<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\FixtureIndexRequest;
use App\Models\Fixture;
use App\Services\FixtureService;
use Illuminate\Database\Eloquent\Collection;

class FixtureController extends Controller
{
    public function index(FixtureIndexRequest $request): Collection
    {
        return Fixture::with(['homeTeam', 'opponentTeam'])
            ->where('week', $request->week)
            ->get();
    }

    public function store(FixtureService $service): Collection
    {
        $service->createFixture();

        return Fixture::with(['homeTeam', 'opponentTeam'])
            ->orderBy('week')
            ->get();
    }
}
