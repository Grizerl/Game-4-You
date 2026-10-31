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
        Schema::table('companies', function (Blueprint $table): void {
            $table->string('slug')->nullable()->after('name');
            $table->unsignedSmallInteger('founded_year')->nullable()->after('country');
            $table->json('socials')->nullable()->after('founded_year');
        });

        $this->backfillSlugs();

        Schema::table('companies', function (Blueprint $table): void {
            $table->string('slug')->nullable(false)->change();
            $table->unique('slug');
        });
    }

    /**
     * Rollback: the new columns are dropped.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table): void {
            $table->dropUnique(['slug']);
            $table->dropColumn(['slug', 'founded_year', 'socials']);
        });
    }

    private function backfillSlugs(): void
    {
        $used = [];

        foreach (DB::table('companies')->orderBy('id')->get(['id', 'name']) as $company) {
            $names = json_decode((string) $company->name, true);
            $name = is_array($names) ? ($names['en'] ?? reset($names) ?: '') : (string) $company->name;

            $base = Str::slug((string) $name, '-', 'uk') ?: 'company-'.$company->id;
            $slug = $base;

            for ($suffix = 2; isset($used[$slug]); $suffix++) {
                $slug = $base.'-'.$suffix;
            }

            $used[$slug] = true;

            DB::table('companies')->where('id', $company->id)->update(['slug' => $slug]);
        }
    }
};
