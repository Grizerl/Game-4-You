<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Creator;
use Illuminate\Database\Seeder;

class CreatorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Creator::truncate();

        // Беремо наявні студії; нові створюються лише коли таблиця порожня.
        $companyIds = Company::pluck('id');

        Creator::factory(30)
            ->state(fn (): array => [
                'company_id' => $companyIds->isNotEmpty() ? $companyIds->random() : Company::factory(),
            ])
            ->create();
    }
}
