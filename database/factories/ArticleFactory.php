<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Article>
 */
class ArticleFactory extends Factory
{
    protected $model = Article::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = rtrim($this->faker->unique()->sentence(5), '.');
        $body = '## '.$this->faker->sentence(3)."\n\n".$this->faker->paragraphs(3, true)."\n\n- ".$this->faker->sentence(4)."\n- ".$this->faker->sentence(4);

        return [
            'title' => ['uk' => $title, 'en' => $title],
            'excerpt' => ['uk' => $this->faker->sentence(14), 'en' => $this->faker->sentence(14)],
            'body' => ['uk' => $body, 'en' => $body],
            'cover_image' => null,
            'published_at' => $this->faker->dateTimeBetween('-3 months', '-1 hour'),
        ];
    }

    public function draft(): static
    {
        return $this->state(fn (): array => ['published_at' => null]);
    }

    public function scheduled(): static
    {
        return $this->state(fn (): array => ['published_at' => now()->addDays(3)]);
    }
}
