<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Company;
use App\Models\Creator;
use App\Models\Game;
use Illuminate\Database\Seeder;

class GamesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Game::truncate();

        // Ігри привʼязуємо до наявних творців, категорій і студій (фабрика створює нові лише якщо таблиця порожня).
        $creators = Creator::pluck('id');
        $categories = Category::pluck('id');
        $companies = Company::pluck('id');

        Game::factory(60)
            ->state(fn (): array => [
                'creator_id' => $creators->isNotEmpty() ? $creators->random() : Creator::factory(),
                'category_id' => $categories->isNotEmpty() ? $categories->random() : Category::factory(),
                'company_id' => $companies->isNotEmpty() ? $companies->random() : Company::factory(),
            ])
            ->create();
    }
}
