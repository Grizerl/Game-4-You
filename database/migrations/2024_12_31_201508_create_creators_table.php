<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('creators', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('images');
            $table->bigInteger('games_count');
            $table->string('position');
            $table->text('games');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('creators');
    }
};
