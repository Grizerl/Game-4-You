<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Обкладинка тепер живе в Media Library; стара колонка лишається як запасний варіант
     * для записів, ще не імпортованих командою media:import-legacy.
     */
    public function up(): void
    {
        Schema::table('games', function (Blueprint $table): void {
            $table->string('cover_image')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('games', function (Blueprint $table): void {
            $table->string('cover_image')->nullable(false)->change();
        });
    }
};
