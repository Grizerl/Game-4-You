<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'title' => 'Action'
        ]);

        Category::create([
            'title' => 'Indie'
        ]);

        Category::create([
            'title' => 'Adventure'
        ]);

        Category::create([
            'title' => 'RPG'
        ]);

        Category::create([
            'title' => 'Strategy'
        ]);

        Category::create([
            'title' => 'Shooter'
        ]);

        Category::create([
            'title' => 'Casual'
        ]);

        Category::create([
            'title' => 'Simulation'
        ]);

        Category::create([
            'title' => 'Puzzle'
        ]);

        Category::create([
            'title' => 'Arcade'
        ]);

        Category::create([
            'title' => 'Platformer'
        ]);

        Category::create([
            'title' => 'Multiplayer'
        ]);

        Category::create([
            'title' => 'Racing'
        ]);

        Category::create([
            'title' => 'Sports'
        ]);

        Category::create([
            'title' => 'Fighting'
        ]);

        Category::create([
            'title' => 'Family'
        ]);

        Category::create([
            'title' => 'Board Games'
        ]);

        Category::create([
            'title' => 'Educational'
        ]);

        Category::create([
            'title' => 'Card'
        ]);
    }
}
