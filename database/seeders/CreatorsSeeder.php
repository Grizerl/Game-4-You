<?php

namespace Database\Seeders;

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
        
        Creator::factory(30)->create();
    }
}
