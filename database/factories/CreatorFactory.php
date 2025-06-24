<?php

namespace Database\Factories;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Creator>
 */
class CreatorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $images = 
        [
            '/assets/images/creators/2a502a143225ad0faf1f8319d58fb6c0.jpg',
            '/assets/images/creators/6ea06e2ddd6c0190e5134f61d826f30f.jpg',
            '/assets/images/creators/8babec5b685ff0be2beee43f3b7b3eb5.jpg',
            '/assets/images/creators/9c760b3ad1d429f4c52ce9e391cb3430.png',
            '/assets/images/creators/51388ad8c1db829a2fcb0353560f0f2a.png',
            '/assets/images/creators/a7b428a6ebf07af89408e4d7032926c1.png',
            '/assets/images/creators/c9422017814776d6dd51c7af5263062d.png',
            '/assets/images/creators/cb0f0a0edf8217f567ca268cffe8ed39.jpg',
            '/assets/images/creators/da3fc907a3af9e494dc671b0c6348f5c.jpg',
            '/assets/images/creators/e4958d0be3261ba1992a7f8053f1a8f6.png',
            '/assets/images/creators/ea01fc54ca9f7b27608d2baf64aed1c7.png',
            '/assets/images/creators/5ba40119fc9e828d487ac77506ee0284.png',
            '/assets/images/creators/6e7ffd8eab3da4726b3a32f3a54dc6ba.png',
            '/assets/images/creators/7a027d94e1ff129dd57c3b224437a4fc.png',
            '/assets/images/creators/7bafe980b3443da6c907728b75910c06.png',
            '/assets/images/creators/41d98b36fafd4f22dadc88337a0014f8.png',
            '/assets/images/creators/74a90ac97694a85f4387e68d586efeaf.png',
            '/assets/images/creators/83bf52ab1647cd9dcd1098d5cefaa5b9.png',
            '/assets/images/creators/85ac6c27a323f4c4fe8c152043e14592.jpg',
            '/assets/images/creators/287df7736bf74448e62f43978c23d4ca.png',
        ];

        $positions = 
        [
            'writer', 
            'director', 
            'producer',
            'designer',
            'programmer',
            'composer',
            'artist',
        ];

        $selectpositions = Arr::random($positions, rand(1, 4));
        
        if (!is_array($selectpositions)) {
            $selectpositions = [$selectpositions];
        }

        $games = [
            'The Elder Scrolls V: Skyrim',
            'Fallout 4',
            'The Elder Scrolls V: Skyrim Special Edition',
            'Wolfenstein II',
            'The New Colossus',
            'Fallout Shelter',
            'Fallout 3',
            'The Elder Scrolls III',
            'Morrowind',
            'The Elder Scrolls V',
            'DOOM (2016)',
            'Wolfenstein: The New Order',
            'DOOM Eternal',
            'Call of Duty: Black Ops III',
            'Global Offensive',
            'Counter-Strike: Global Offensive',
        ];

        $selectgames = Arr::random($games, rand(2, 9));
        
        if (!is_array($selectgames)) {
            $selectgames = [$selectgames];
        }
        return [
            'name' => $this->faker->name,
            'images' => Arr::random($images),
            'games_count' => $this->faker->numberBetween(5, 50),
            'position' => implode(', ', $selectpositions),
            'games' => implode(', ', $selectgames),
        ];
    }
}
