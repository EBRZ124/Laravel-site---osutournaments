<?php

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
        Schema::create('comments', function(Blueprint $t) {
            $t->id();
            $t->unsignedBigInteger('tournament_id');
            $t->unsignedBigInteger('user_id');
            $t->text('body');
            $t->timestamps();
            $t->foreign('tournament_id')->references('id')->on('tournaments')->cascadeOnDelete();
            $t->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
          });
          
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
