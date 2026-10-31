<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('games', function (Blueprint $table): void {
            $table->string('slug')->nullable()->after('name');
            $table->date('released_at')->nullable()->after('platforms');
            $table->string('trailer_url')->nullable()->after('released_at');
            $table->json('screenshots')->nullable()->after('trailer_url');
        });

        // Раніше «датою виходу» на сайті була дата додавання, тож зберігаємо її як стартове значення.
        DB::table('games')->whereNotNull('created_at')->update(['released_at' => DB::raw('DATE(created_at)')]);

        $this->backfillSlugs();

        Schema::table('games', function (Blueprint $table): void {
            $table->string('slug')->nullable(false)->change();
            $table->unique('slug');
        });
    }

    /**
     * Rollback: the new columns are dropped.
     */
    public function down(): void
    {
        Schema::table('games', function (Blueprint $table): void {
            $table->dropUnique(['slug']);
            $table->dropColumn(['slug', 'released_at', 'trailer_url', 'screenshots']);
        });
    }

    private function backfillSlugs(): void
    {
        $used = [];

        foreach (DB::table('games')->orderBy('id')->get(['id', 'name']) as $game) {
            $names = json_decode((string) $game->name, true);
            $name = is_array($names) ? ($names['en'] ?? reset($names) ?: '') : (string) $game->name;

            $base = Str::slug((string) $name, '-', 'uk') ?: 'game-'.$game->id;
            $slug = $base;

            for ($suffix = 2; isset($used[$slug]); $suffix++) {
                $slug = $base.'-'.$suffix;
            }

            $used[$slug] = true;

            DB::table('games')->where('id', $game->id)->update(['slug' => $slug]);
        }
    }
};
