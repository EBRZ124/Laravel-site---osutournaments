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
        Schema::create('tournaments', function(Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->decimal('prize_pool', 10, 2)->nullable();
            $table->string('competition_type');
            $table->string('tournament_type');
            $table->string('location')->nullable();
            $table->timestamps();
          });
          
            
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournaments');
    }
};
