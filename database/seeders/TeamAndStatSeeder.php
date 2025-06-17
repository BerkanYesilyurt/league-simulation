<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;

class TeamAndStatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teams = ['Liverpool', 'Manchester City', 'Chelsea', 'Arsenal'];
        foreach ($teams as $team) {
            $team = Team::create(['name' => $team]);
            $team->stats()->create(['strength' => mt_rand(0, 100) / 100]);
        }
    }
}
