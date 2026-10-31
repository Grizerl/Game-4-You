<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompaniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::truncate();

        // Логотипи беремо з уже завантажених файлів (public/uploads/company), якщо вони є.
        $logos = collect(glob(public_path('uploads/company/*')) ?: [])
            ->map(fn (string $path): string => 'uploads/company/'.basename($path))
            ->values();

        Company::factory(15)
            ->state(fn (): array => ['logo_path' => $logos->isNotEmpty() ? $logos->random() : null])
            ->create();
    }
}
