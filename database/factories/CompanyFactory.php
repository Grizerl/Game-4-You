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

        $socials = array_filter([
            'website' => $this->faker->boolean(80) ? $this->faker->url() : null,
            'x' => $this->faker->boolean(50) ? 'https://x.com/'.$this->faker->userName() : null,
            'youtube' => $this->faker->boolean(40) ? 'https://www.youtube.com/@'.$this->faker->userName() : null,
        ]);

        return [
            'name' => ['uk' => $name, 'en' => $name],
            'description' => ['uk' => $this->faker->paragraph(), 'en' => $this->faker->paragraph()],
            'country' => ['uk' => 'Україна', 'en' => 'Ukraine'],
            'founded_year' => $this->faker->numberBetween(1980, 2020),
            'socials' => $socials ?: null,
            'logo_path' => null,
        ];
    }

    public function withoutLogo(): static
    {
        return $this->state(fn (): array => ['logo_path' => null]);
    }
}
