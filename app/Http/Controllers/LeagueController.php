<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\LeagueStoreRequest;
use App\Services\GameService;
use App\Services\ResetService;
use Illuminate\Database\Eloquent\Collection;

class LeagueController extends Controller
{
    public function store(LeagueStoreRequest $request, GameService $gameService): Collection
    {
        return $gameService->playGamesAndGetFixture($request->week, $request->all);
    }

    public function destroy(ResetService $service): \Illuminate\Http\JsonResponse
    {
        $service->reset();
        return response()->json(['message' => 'success']);
    }
}
