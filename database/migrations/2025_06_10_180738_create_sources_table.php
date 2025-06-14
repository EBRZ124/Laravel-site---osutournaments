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
Schema::create('sources', function (Blueprint $t) {
    $t->id();
    $t->unsignedBigInteger('tournament_id');
    $t->string('stream_url')->nullable();
    $t->string('video_url')->nullable();
    $t->string('forum_url')->nullable();
    $t->timestamps();

    $t->foreign('tournament_id')->references('id')->on('tournaments')->cascadeOnDelete();
});

          
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sources');
    }
};
