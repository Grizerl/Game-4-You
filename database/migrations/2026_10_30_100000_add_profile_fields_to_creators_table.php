<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('creators', function (Blueprint $table): void {
            $table->string('slug')->nullable()->after('last_name');
            $table->json('country')->nullable()->after('role');
            $table->unsignedSmallInteger('career_start')->nullable()->after('country');
            $table->json('socials')->nullable()->after('career_start');
            $table->string('avatar')->nullable()->change();
        });

        $this->backfillSlugs();

        Schema::table('creators', function (Blueprint $table): void {
            $table->string('slug')->nullable(false)->change();
            $table->unique('slug');
        });
    }

    /**
     * Reverse the migrations.
     *
     * `avatar` stays nullable: restoring NOT NULL would fail for creators without a photo.
     */
    public function down(): void
    {
        Schema::table('creators', function (Blueprint $table): void {
            $table->dropUnique(['slug']);
            $table->dropColumn(['slug', 'country', 'career_start', 'socials']);
        });
    }

    private function backfillSlugs(): void
    {
        $used = [];

        foreach (DB::table('creators')->orderBy('id')->get(['id', 'first_name', 'last_name']) as $creator) {
            $base = Str::slug(trim($creator->first_name.' '.$creator->last_name), '-', 'uk')
                ?: 'creator-'.$creator->id;

            $slug = $base;

            for ($suffix = 2; isset($used[$slug]); $suffix++) {
                $slug = $base.'-'.$suffix;
            }

            $used[$slug] = true;

            DB::table('creators')->where('id', $creator->id)->update(['slug' => $slug]);
        }
    }
};
