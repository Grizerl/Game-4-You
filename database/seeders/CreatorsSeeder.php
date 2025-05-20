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
        Creator::create([
            'name' => 'Marc Laidlaw',
            'images' => '/assets/images/creators/2a502a143225ad0faf1f8319d58fb6c0.jpg',
            'games_count' => 15,
            'position' => 'writer',
            'games' => 'Portal 2, Counter-Strike: Global Offensive, Portal, Left 4 Dead 2, Half-Life 2, Dota 2',
        ]);

        Creator::create([
            'name' => 'Robin Walker',
            'images' => '/assets/images/creators/6ea06e2ddd6c0190e5134f61d826f30f.jpg',
            'games_count' => 14,
            'position' => 'designer',
            'games' => 'Portal 2, Counter-Strike: Global Offensive, Portal, Left 4 Dead 2, Team Fortress 2, Half-Life 2: Episode One',
        ]);

        Creator::create([
            'name' => 'David Speyrer',
            'images' => '/assets/images/creators/8babec5b685ff0be2beee43f3b7b3eb5.jpg',
            'games_count' => 12,
            'position' => 'programmer',
            'games' => 'Portal 2, Portal, Left 4 Dead 2, Half-Life 2, Half-Life 2: Episode One, Half-Life 2: Episode Two',
        ]);

        Creator::create([
            'name' => 'Jesper Kyd',
            'images' => '/assets/images/creators/9c760b3ad1d429f4c52ce9e391cb3430.png',
            'games_count' => 49,
            'position' => 'composer',
            'games' => 'Borderlands 2, Borderlands, Borderlands: The Pre-Sequel, Warhammer: Vermintide 2, Hitman 2, Assassin Creed II',
        ]);

        Creator::create([
            'name' => 'Cris Velasco',
            'images' => '/assets/images/creators/51388ad8c1db829a2fcb0353560f0f2a.png',
            'games_count' => 57,
            'position' => 'composer',
            'games' => 'Borderlands 2, Borderlands, Injustice: Gods Among Us Ultimate Edition, Company of Heroes 2, Bloodborne, Resident Evil 7',
        ]);

        Creator::create([
            'name' => 'Dan Houser',
            'images' => '/assets/images/creators/a7b428a6ebf07af89408e4d7032926c1.png',
            'games_count' => 28,
            'position' => 'writer, producer, designer',
            'games' => 'Grand Theft Auto V, Red Dead Redemption 2, Grand Theft Auto IV, Grand Theft Auto: San Andreas, L.A. Noire, Grand Theft Auto: Vice City',
        ]);

        Creator::create([
            'name' => 'Eric Smith',
            'images' => '/assets/images/creators/c9422017814776d6dd51c7af5263062d.png',
            'games_count' => 19,
            'position' => 'writer, artist',
            'games' => 'Portal 2, Counter-Strike: Global Offensive, Portal, Left 4 Dead 2, Half-Life 2: Episode One, Half-Life 2: Episode Two',
        ]);

        Creator::create([
            'name' => 'Mike Morasky',
            'images' => '/assets/images/creators/cb0f0a0edf8217f567ca268cffe8ed39.jpg',
            'games_count' => 19,
            'position' => ' writer, composer',
            'games' => 'Portal 2, Counter-Strike: Global Offensive, Portal, Left 4 Dead 2, Team Fortress 2, Half-Life 2: Episode Two',
        ]);

        Creator::create([
            'name' => 'Erik Wolpaw',
            'images' => '/assets/images/creators/da3fc907a3af9e494dc671b0c6348f5c.jpg',
            'games_count' => 19,
            'position' => 'writer',
            'games' => 'Portal 2, Counter-Strike: Global Offensive, Portal, Left 4 Dead 2, Half-Life 2: Episode One, Half-Life 2: Episode Two',
        ]);

        Creator::create([
            'name' => 'Erik Johnson',
            'images' => '/assets/images/creators/e4958d0be3261ba1992a7f8053f1a8f6.png',
            'games_count' => 11,
            'position' => ' producer',
            'games' => 'Portal 2, Counter-Strike: Global Offensive, Portal, Left 4 Dead 2, Dota 2, Half-Life 2: Episode One',
        ]);

        Creator::create([
            'name' => 'Dario Casali',
            'images' => '/assets/images/creators/ea01fc54ca9f7b27608d2baf64aed1c7.png',
            'games_count' => 11,
            'position' => ' director',
            'games' => 'Portal 2, Counter-Strike: Global Offensive, Portal, Left 4 Dead 2, Half-Life 2: Episode One, Half-Life 2: Episode Two',
        ]);

        Creator::create([
            'name' => 'Rick Johnson',
            'images' => '/assets/images/creators/5ba40119fc9e828d487ac77506ee0284.png',
            'games_count' => 24,
            'position' => 'programmer',
            'games' => 'Portal 2, Counter-Strike: Global Offensive, Left 4 Dead 2, Left 4 Dead, Alien Swarm, Star Wars Jedi Knight: Jedi Academy',
        ]);

        Creator::create([
            'name' => 'Aaron Garbut',
            'images' => '/assets/images/creators/6e7ffd8eab3da4726b3a32f3a54dc6ba.png',
            'games_count' => 13,
            'position' => 'artist',
            'games' => 'Portal 2, Counter-Strike: Global Offensive, Left 4 Dead 2, Left 4 Dead, Alien Swarm, Star Wars Jedi Knight: Jedi Academy',
        ]);

        Creator::create([
            'name' => 'Jeremy Soule',
            'images' => '/assets/images/creators/7a027d94e1ff129dd57c3b224437a4fc.png',
            'games_count' => 60,
            'position' => 'composer',
            'games' => 'The Elder Scrolls V: Skyrim, Prey, The Elder Scrolls V: Skyrim Special Edition, Star Wars: Knights of the Old Re, Company of Heroes, The Elder Scrolls Online: Tamriel Unlimited',
        ]);

        Creator::create([
            'name' => 'Leslie Benzies',
            'images' => '/assets/images/creators/7bafe980b3443da6c907728b75910c06.png',
            'games_count' => 15,
            'position' => 'director, producer, designer ',
            'games' => 'Grand Theft Auto V, Grand Theft Auto IV, Grand Theft Auto: San Andreas, Grand Theft Auto: Vice City, Grand Theft Auto III, Red Dead Redemption',
        ]);

        Creator::create([
            'name' => 'Brandon Reinhart',
            'images' => '/assets/images/creators/41d98b36fafd4f22dadc88337a0014f8.png',
            'games_count' => 9,
            'position' => 'director, programmer',
            'games' => 'Portal 2, Counter-Strike: Global Offensive, Left 4 Dead 2, Left 4 Dead, Alien Swarm, Duke Nukem Forever',
        ]);

        Creator::create([
            'name' => 'Kevin Cloud',
            'images' => '/assets/images/creators/65f760dcbbf10397d28d7349b3c7c07c.png',
            'games_count' => 49,
            'position' => 'director, artist, producer',
            'games' => 'DOOM (2016), DOOM Eternal, Quake Champions, DOOM 3, Quake, DOOM II',
        ]);

        Creator::create([
            'name' => 'Jay Pinkerton',
            'images' => '/assets/images/creators/74a90ac97694a85f4387e68d586efeaf.png',
            'games_count' => 7,
            'position' => 'writer',
            'games' => 'Portal 2, Counter-Strike: Global Offensive, Left 4 Dead 2, Left 4 Dead, Alien Swarm, Aperture Desk Job',
        ]);

        Creator::create([
            'name' => 'Brian Raffel',
            'images' => '/assets/images/creators/83bf52ab1647cd9dcd1098d5cefaa5b9.png',
            'games_count' => 34,
            'position' => 'director, artist, designer',
            'games' => 'Call of Duty: Black Ops III, Call of Duty: Black Ops, Call of Duty: WWII, Call of Duty: Modern Warfare 3, Call of Duty: Modern Warfare Remastered, Star Wars Jedi Knight: Jedi Academy',
        ]);

        Creator::create([
            'name' => 'Darin McNeil',
            'images' => '/assets/images/creators/85ac6c27a323f4c4fe8c152043e14592.jpg',
            'games_count' => 56,
            'position' => 'programmer',
            'games' => 'DOOM (2016), Wolfenstein: The New Order, DOOM Eternal, Wolfenstein II: The New Colossus, Quake Champions, Call of Duty: Black Ops',
        ]);

        Creator::create([
            'name' => 'Todd Howard',
            'images' => '/assets/images/creators/287df7736bf74448e62f43978c23d4ca.png',
            'games_count' => 23,
            'position' => 'writer, director, producer',
            'games' => 'The Elder Scrolls V: Skyrim, Fallout 4, The Elder Scrolls V: Skyrim Special Edition, Fallout 3, Fallout 3: Game of the Year Edition, The Elder Scrolls III: Morrowind',
        ]);

        Creator::create([
            'name' => 'Tim Willits',
            'images' => '/assets/images/creators/af78ede6f9fe3167a2786ef9c25c536f.jpg',
            'games_count' => '35',
            'position' => 'director, producer, designer',
            'games' => 'DOOM (2016), Quake Champions, Rage, DOOM 3, Quake, DOOM II',
        ]);


        Creator::create([
            'name' => 'Emil Pagliarulo',
            'images' => '/assets/images/creators/c92a54e751af20620dde6cc14dc3a2b4.png',
            'games_count' => '16',
            'position' => 'writer, designer',
            'games' => 'The Elder Scrolls V: Skyrim, Fallout 4, The Elder Scrolls V: Skyrim Special Edition, Wolfenstein II: The New Colossus, Fallout Shelter, Fallout 3',
        ]);

    }
}
