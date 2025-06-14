<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('player_tournament', function (Blueprint $table) {
            $table->unsignedBigInteger('player_id');
            $table->unsignedBigInteger('tournament_id');
            $table->primary(['player_id','tournament_id']);
            $table->foreign('player_id')->references('id')->on('players')->cascadeOnDelete();
            $table->foreign('tournament_id')->references('id')->on('tournaments')->cascadeOnDelete();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('player_tournament');
    }
};
