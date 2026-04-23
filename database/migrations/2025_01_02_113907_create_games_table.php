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
        Schema::create('games', function (Blueprint $table): void {
            $table->id();

            $table->string('name');
            $table->text('description');
            $table->string('cover_image');
            $table->bigInteger('rating')->default(0);
            $table->string('platforms')->nullable();

            $table->unsignedBigInteger('category_id')
                ->constrained()
                ->onDelete('cascade');
            $table->unsignedBigInteger('creator_id')
                ->constrained()
                ->onDelete('cascade');
            $table->unsignedBigInteger('company_id')
                ->constrained()
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
