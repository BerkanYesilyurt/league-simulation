<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Database\Eloquent\Collection;

class TeamController extends Controller
{
    public function index(): Collection
    {
        return Team::all();
    }

    public function stats(): Collection
    {
        return Team::with('stats')->get();
    }
}
