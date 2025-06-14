<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('match_ups', function (Blueprint $t) {
            $t->id();
            $t->unsignedBigInteger('tournament_id');
            $t->unsignedBigInteger('player1_id');
            $t->unsignedBigInteger('player2_id');
            $t->integer('player1_score')->nullable();
            $t->integer('player2_score')->nullable();
            $t->unsignedInteger('round')->default(0);
            $t->timestamps();

            $t->foreign('tournament_id')->references('id')->on('tournaments')->cascadeOnDelete();
            $t->foreign('player1_id')->references('id')->on('players')->cascadeOnDelete();
            $t->foreign('player2_id')->references('id')->on('players')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('match_ups');
    }
};
