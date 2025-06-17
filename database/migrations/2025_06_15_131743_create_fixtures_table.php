<?php

use App\Enums\MatchStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fixtures', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('week');
            $table->unsignedTinyInteger('home_team_id')->index();
            $table->unsignedTinyInteger('opponent_team_id')->index();
            $table->unsignedTinyInteger('home_team_score')->nullable();
            $table->unsignedTinyInteger('opponent_team_score')->nullable();
            $table->unsignedTinyInteger('status')->default(MatchStatus::PENDING);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fixtures');
    }
};
