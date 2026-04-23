<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $images = [
            '/assets/images/games/618c2031a07bbff6b4f611f10b6bcdbc.jpg',
            '/assets/images/games/2bac0e87cf45e5b508f227d281c9252a.jpg',
            '/assets/images/games/73619bd336c894d6941d926bfd563946.jpg',
            '/assets/images/games/021c4e21a1824d2526f925eff6324653.jpg',
            '/assets/images/games/7fa0b586293c5861ee32490e953a4996.jpg',
            '/assets/images/games/d588947d4286e7b5e0e12e1bea7d9844.jpg',
            '/assets/images/games/5118aff5091cb3efec399c808f8c598f.jpg',
            '/assets/images/games/fc1307a2774506b5bd65d7e8424664a7.jpg',
            '/assets/images/games/49c3dfa4ce2f6f140cc4825868e858cb.jpg',
            '/assets/images/games/562553814dd54e001a541e4ee83a591c.jpg',
            '/assets/images/games/b8c243eaa0fbac8115e0cdccac3f91dc.jpg',
            '/assets/images/games/bc06a29ceac58652b684deefe7d56099.jpg',
            '/assets/images/games/d82990b9c67ba0d2d09d4e6fa88885a7.jpg',
            '/assets/images/games/73eecb8909e0c39fb246f457b5d6cbbe.jpg',
            '/assets/images/games/4be6a6ad0364751a96229c56bf69be59.jpg',
            '/assets/images/games/49016e06ae2103881ff6373248843069.jpg',
            '/assets/images/games/737ea5662211d2e0bbd6f5989189e4f1.jpg',
            '/assets/images/games/ee3e10193aafc3230ba1cae426967d10.jpg',
            '/assets/images/games/d1a2e99ade53494c6330a0ed945fe823.jpg',
            '/assets/images/games/8d69eb6c32ed6acfd75f82d532144993.jpg',
            '/assets/images/games/46d98e6910fbc0706e2948a7cc9b10c5.jpg',
            '/assets/images/games/b45575f34285f2c4479c9a5f719d972e.jpg',
            '/assets/images/games/4cfc6b7f1850590a4634b08bfab308ab.jpg',
            '/assets/images/games/8cce7c0e99dcc43d66c8efd42f9d03e3 (1).jpg',
            '/assets/images/games/9ddabb34840ea9227556670606cf8ea3.jpg',
            '/assets/images/games/9fa63622543e5d4f6d99aa9d73b043de.jpg',
            '/assets/images/games/9424d6bb763dc38d9378b488603c87fa.jpg',
            '/assets/images/games/f466571d536f2e3ea9e815ad17177501 (1).jpg',
            '/assets/images/games/9424d6bb763dc38d9378b488603c87fa.jpg',
            '/assets/images/games/8a02f84a5916ede2f923b88d5f8217ba.jpg',
            '/assets/images/games/48cb04ca483be865e3a83119c94e6097.jpg',
            '/assets/images/games/b54598d1d5cc31899f4f0a7e3122a7b0.jpg',
            '/assets/images/games/f87457e8347484033cb34cde6101d08d.jpg'
        ];
               
        $category = 
        [
            'Action',
            'Indie',
            'Adventure',
            'RPG',
            'Strategy',
            'Shooter',
            'Casual',
            'Simulation',
            'Puzzle',
            'Arcade',
            'Platformer',
            'Multiplayer',
            'Racing',
            'Sports',
            'Fighting',
            'Family',
            'Board Games',
            'Educational',
            'Card',
           
        ];

        $allPlatforms = ['PC', 'PlayStation 3',  'PlayStation 5', 'Xbox Series X', 'PlayStation 4', 'Xbox Series S/X'];

        $selectedPlatforms = Arr::random($allPlatforms, rand(2, 5));
        
        if (!is_array($selectedPlatforms)) {
            $selectedPlatforms = [$selectedPlatforms];
        }

        return 
        [
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraphs(5, true),
            'cover_image' => Arr::random($images),
            'rating' => $this->faker->numberBetween(100, 10000),
            'platforms' => implode(', ', $selectedPlatforms), 
            'creator_id' => $this->faker->numberBetween(1, 19),
            'category_id' => $this->faker->numberBetween(1, 19),
            'company_id' => $this->faker->numberBetween(1, 19),
        ];
    }
}
