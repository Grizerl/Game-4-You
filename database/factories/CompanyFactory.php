<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Company>
 */
class CompanyFactory extends Factory
{
    protected $model = Company::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->company();

        return [
            'name' => ['uk' => $name, 'en' => $name],
            'description' => ['uk' => $this->faker->sentence(), 'en' => $this->faker->sentence()],
            'country' => ['uk' => 'Україна', 'en' => 'Ukraine'],
            'logo_path' => null,
        ];
    }
}
