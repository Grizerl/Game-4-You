<?php

namespace Database\Seeders;

use App\Models\Game;
use Illuminate\Database\Seeder;

class GamesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Game::create([
            'name' => 'The Witcher 3: Wild Hunt',
            'description' => 'The third game in a series, it holds nothing back from the player. Open world adventures of the renowned monster slayer Geralt of Rivia are now even on a larger scale. Following the source material more accurately, this time Geralt is trying to find the child of the prophecy, Ciri while making a quick coin from various contracts on the side. Great attention to the world building above all creates an immersive story, where your decisions will shape the world around you.
                CD Project Red are infamous for the amount of work they put into their games, and it shows, because aside from classic third-person action RPG base game they provided 2 massive DLCs with unique questlines and 16 smaller DLCs, containing extra quests and items.
                Players praise the game for its atmosphere and a wide open world that finds the balance between fantasy elements and realistic and believable mechanics, and the game deserved numerous awards for every aspect of the game, from music to direction.',
            'images' => '/assets/images/games/618c2031a07bbff6b4f611f10b6bcdbc.jpg',
            'release_date' => '2015-05-18',
            'updated' => '2024-12-30',
            'cursing' => '6741',
            'platforms' => 'Xbox Series S/X, PlayStation 5, macOS, PlayStation 4, Nintendo Switch, PC, Xbox One',
            'developers' => 'CD PROJEKT RED',
            'genres' => 'Action, RPG',
            'publishers' => 'CD PROJEKT RED',
            'category_id' => 1
        ]);

        Game::create([
            'name' => 'Portal 2',
            'description' => 'Portal 2 is a first-person puzzle game developed by Valve Corporation and released on April 19, 2011 on Steam, PS3 and Xbox 360. It was published by Valve Corporation in digital form and by Electronic Arts in physical form.
                Its plot directly follows the first games, taking place in the Half-Life universe. You play as Chell, a test subject in a research facility formerly ran by the company Aperture Science, but taken over by an evil AI that turned upon its creators, GladOS. After defeating GladOS at the end of the first game but failing to escape the facility, Chell is woken up from a stasis chamber by an AI personality core, Wheatley, as the unkempt complex is falling apart. As the two attempt to navigate through the ruins and escape, they stumble upon GladOS, and accidentally re-activate her...
                Portal 2s core mechanics are very similar to the first games ; the player must make their way through several test chambers which involve puzzles. For this purpose, they possess a Portal Gun, a weapon capable of creating teleportation portals on white surfaces. This seemingly simple mechanic and its subtleties coupled with the many different puzzle elements that can appear in puzzles allows the game to be easy to start playing, yet still feature profound gameplay. The sequel adds several new puzzle elements, such as gel that can render surfaces bouncy or allow you to accelerate when running on them.
                The game is often praised for its gameplay, its memorable dialogue and writing and its aesthetic. Both games in the series are responsible for inspiring most puzzle games succeeding them, particularly first-person puzzle games. The series, its characters and even its items such as the portal gun and the companion cube have become a cultural icon within gaming communities.',
            'images' => '/assets/images/games/2bac0e87cf45e5b508f227d281c9252a.jpg',
            'release_date' => '2011-04-18',
            'updated' => '2024-12-30',
            'cursing' => '5793',
            'platforms' => 'PlayStation 3, PC, Xbox 360, Linux, macOS, Xbox One',
            'developers' => 'Valve Software',
            'genres' => 'Shooter, Puzzle',
            'publishers' => 'Electronic Arts, Valve',
            'category_id' => 1
        ]);

        Game::create([
            'name' => 'Counter-Strike: Global Offensive',
            'description' => 'Counter-Strike is a multiplayer phenomenon in its simplicity. No complicated narratives to explain the source of the conflict, no futuristic and alien threats, but counter-terrorists against terrorists. Arena shooter at its core, CS:GO provides you with various methods of disposing enemies and reliant on cooperation within the team. During the round of the classical clash mode, you will gradually receive currency to purchase different equipment. Each player can carry a primary weapon, secondary pistol, knife and a set of grenades, which all can change the battle if wielded by the skilled player.
                Objectives are clear and vary from map to map, from game mode to game mode. Stop the terrorists from planting explosives, stop the counter-terrorist from retrieving the hostages, kill everyone who isn’t you and just perform the best with.
                CS:GO is one of the major cybersport discipline, which makes playing it more exciting to some players. Aside from purchasing the game, CS:GO is infamous for its loot case system, that requires players to purchase keys, in order to open said cases. Customization items consist of weapon skins, weapon stickers, and sprays that do not affect gameplay and have purely visual value to the player.',
            'images' => '/assets/images/games/73619bd336c894d6941d926bfd563946.jpg',
            'release_date' => '2012-08-21',
            'updated' => '2024-12-31',
            'cursing' => '3534',
            'platforms' => 'PC, Linux, Xbox 360, PlayStation 3',
            'developers' => 'Valve Software, Hidden Path Entertainment',
            'genres' => 'Shooter',
            'publishers' => 'Valve',
            'category_id' => 1
        ]);

        Game::create([
            'name' => 'Tomb Raider (2013)',
            'description' => 'A cinematic revival of the series in its action third person form, Tomb Rider follows Lara in her least experience period of life – her youth. Heavily influenced by Naughty Dog’s “Uncharted”, the game is a mix of everything, from stealth and survival to combat and QTE action scenes.
                Young Lara Croft arrives on the Yamatai, lost island near Japan, as the leader of the expedition in search of the Yamatai Kingdom, with a diverse team of specialists. But shipwreck postponed the successful arrival and seemingly forgotten island is heavily populated with hostile inhabitants, cultists of Solarii Brotherhood.
                The game will be graphic at times, especially after failed QTE’s during some of the survival scenes, but overall players will enjoy classic action adventure, reminiscent of the beginning of the series. This game is not a direct sequel or continuation of existing sub-series within the franchise, but a reboot, setting up Tomb Raider to represent modern gaming experience.',
            'images' => '/assets/images/games/021c4e21a1824d2526f925eff6324653.jpg',
            'release_date' => '2013-03-05',
            'updated' => '2024-12-30',
            'cursing' => '3944',
            'platforms' => 'PlayStation 4, PlayStation 3, Xbox 360, macOS, PC, Xbox One',
            'developers' => 'Crystal Dynamics',
            'genres' => 'Action, Fighting',
            'publishers' => 'Square Enix',
            'category_id' => 1
        ]);

        Game::create([
            'name' => 'Portal',
            'description' => 'Every single time you click your mouse while holding a gun, you expect bullets to fly and enemies to fall. But here you will try out the FPS game filled with environmental puzzles and engaging story.
                Silent template for your adventures, Chell, wakes up in a testing facility. She’s a subject of experiments on instant travel device, supervised by snarky and hostile GLaDOS.
                Players will have to complete the tests, room by room, expecting either reward, freedom or more tests. By using the gun, that shoots portals (Portal-Gun™), players will move blocks, travel great distance quickly and learn about your current situation, which is unraveled through environmental storytelling. What you will be told might be different from what you will see.',
            'images' => '/assets/images/games/7fa0b586293c5861ee32490e953a4996.jpg',
            'release_date' => '2007-10-09',
            'updated' => '2024-12-30',
            'cursing' => '4786',
            'platforms' => 'macOS, PC, Android, PlayStation 3, Xbox 360, Linux, Nintendo Switch',
            'developers' => 'Valve Software, NVIDIA Lightspeed Studios',
            'genres' => 'Action, Puzzle',
            'publishers' => 'Valve, Buka Entertainment, NVIDIA, CyberFront',
            'category_id' => 1
        ]);

        Game::create([
            'name' => 'Left 4 Dead 2',
            'description' => 'Cooperative survival continues with a different set of characters. New survivors are making their way through 5 campaigns with an added ability to play through the story of the first game as well, using not only expanded arsenal of 20 ranged and 10 melee weapons but improved AI Director. Your surroundings and weather will change; enemy and item placement will differ from map to map, from difficulty to difficulty. New unique special zombies, placed in the unlucky for the player spot, can end your run.
                High compatibility with community mods will allow you not only to add user-created maps but player models, enemy models, and even in-game music, which will help any player to create the unique experience on top of solid game mechanics.',
            'images' => '/assets/images/games/d588947d4286e7b5e0e12e1bea7d9844.jpg',
            'release_date' => '2009-11-17',
            'updated' => '2024-12-30',
            'cursing' => '3305',
            'platforms' => 'Xbox 360, Linux, PC, macOS',
            'developers' => 'Valve Software, Turtle Rock Studios',
            'genres' => 'Action, Shooter',
            'publishers' => 'Electronic Arts, Valve, Akella',
            'category_id' => 2
        ]);

        Game::create([
            'name' => 'Red Dead Redemption 2',
            'description' => 'America, 1899. The end of the wild west era has begun as lawmen hunt down the last remaining outlaw gangs. Those who will not surrender or succumb are killed.
                After a robbery goes badly wrong in the western town of Blackwater, Arthur Morgan and the Van der Linde gang are forced to flee. With federal agents and the best bounty hunters in the nation massing on their heels, the gang must rob, steal and fight their way across the rugged heartland of America in order to survive. As deepening internal divisions threaten to tear the gang apart, Arthur must make a choice between his own ideals and loyalty to the gang who raised him.
                From the creators of Grand Theft Auto V and Red Dead Redemption, Red Dead Redemption 2 is an epic tale of life in America at the dawn of the modern age.',
            'images' => '/assets/images/games/5118aff5091cb3efec399c808f8c598f.jpg',
            'release_date' => '2018-10-26',
            'updated' => '2024-12-30',
            'cursing' => '5124',
            'platforms' => 'PC, PlayStation 4, Xbox One',
            'developers' => 'Rockstar Games',
            'genres' => 'Action',
            'publishers' => 'Rockstar Games',
            'category_id' => 2
        ]);

        Game::create([
            'name' => 'BioShock Infinite',
            'description' => 'The third game in the series, Bioshock takes the story of the underwater confinement within the lost city of Rapture and takes it in the sky-city of Columbia. Players will follow Booker DeWitt, a private eye with a military past; as he will attempt to wipe his debts with the only skill he’s good at – finding people. Aside from obvious story and style differences, this time Bioshock protagonist has a personality, character, and voice, no longer the protagonist is a silent man, trying to survive.
                Open and bright level design of Columbia shows industrial colonial America in a seemingly endless carnival. But Bioshock is not famous for its visuals, but for its story. Mystery and creative vision of Irrational Games invite players to uncover the secrets of Columbia’s leader - Zachary Comstock and save Elizabeth, the girl, that’s been locked up in the flying city since her birth.',
            'images' => '/assets/images/games/fc1307a2774506b5bd65d7e8424664a7.jpg',
            'release_date' => '2013-03-26',
            'updated' => '2024-12-30',
            'cursing' => '4059',
            'platforms' => 'PlayStation 4, Xbox 360, Nintendo Switch, Linux, PC, PlayStation 3, Xbox One',
            'developers' => 'Aspyr Media, 2K Australia, Irrational Games',
            'genres' => 'Action, Shooter',
            'publishers' => '2K Games, Aspyr',
            'category_id' => 2
        ]);

        Game::create([
            'name' => 'Borderlands 2',
            'description' => 'Sequel to the 4-player cooperative FPS RPG Borderlands, where the new team of Vault Hunters arrives on the infamous planet Pandora in order to get the riches, hidden inside the Vault, and help to free the planet from the Handsome Jack, President of Hyperion. Clear out the endless waves and groups and marauders with various weapon types and character abilities.
                Unlike the first game, Borderlands 2 provided DLC not only expanding the world of Pandora with stand-alone story campaigns but adding 2 more characters. Now the main cast consists of Gunzerker Salvador(dual-wields guns at command), Siren Maya (holds and paralyzes the enemy), Commando Axton (summons turrets) and Zer0 the Assasin (invisible sniper ninja). But with the DLC players can try out summoning giant flying robots with Gaige the Mechromancer and Krieg the Psycho.
                Most of the game charm and popularity of Borderlands 2 comes from the supporting cast and the personalities of the NPC, making this fast-paced shooter with optional cover stand out.',
            'images' => '/assets/images/games/49c3dfa4ce2f6f140cc4825868e858cb.jpg',
            'release_date' => '2012-09-18',
            'updated' => '2024-12-30',
            'cursing' => '3214',
            'platforms' => 'PlayStation 3, macOS, PC, Android, Linux, PS Vita, Xbox 360',
            'developers' => 'Aspyr Media, 2K, Gearbox Software, Sony Computer Entertainment America',
            'genres' => 'Action, Shooter, RPG',
            'publishers' => '2K Games, Aspyr',
            'category_id' => 2
        ]);

        Game::create([
            'name' => 'Life is Strange',
            'description' => 'Interactive storytelling and plot-heavy games gained popularity, and “Life is Strange” arrived as teen mystery adventure. The plot will go through the life of Maxine, a teenager in possession of curious power, allowing her to stop and rewind time, in order to manipulate her surroundings. Max, after the reunion with her friend Chloe, is on the path to uncovering the secrets of Arcadia Bay. Players will have to deal with puzzle solving through the fetch quests, in order to change the world around them.
                The game puts players in situations, where they’re forced to make a moral choice, going through the decision which may have short-term or long-term consequences. Every choice made by the player will trigger the butterfly effect, surrounding the first playthrough of the game with a lot of emotional struggle, thoughtfully crafted by the developers at Dontnod Entertainment. Life is Strange is third person adventure game, where players might seem just as an observer of the stories, unfolding in front of them.',
            'images' => '/assets/images/games/562553814dd54e001a541e4ee83a591c.jpg',
            'release_date' => '2015-01-29   ',
            'updated' => '2024-12-30',
            'cursing' => '3662',
            'platforms' => 'PC, Linux, PlayStation 3, macOS, iOS, Xbox 360, Android, PlayStation 4, Xbox One',
            'developers' => 'DONTNOD Entertainment',
            'genres' => 'Adventure',
            'publishers' => 'Square Enix, Feral Interactive',
            'category_id' => 3
        ]);

        Game::create([
            'name' => 'Half-Life 2',
            'description' => 'Gordon Freeman became the most popular nameless and voiceless protagonist in gaming history. He is painted as the most famous scientist and a hero within the world of Half-Life, and for a good reason. In the first game he saved the planet from alien invasion, this time, when the invasion is already begun, the world needs his help one more time. And you, as a player, will help this world to survive. This time Gordon arrives in City 17, ravaged and occupied by Combines, where he meets his old Black Mesa friends.
                What is different, aside from the overall design quality, is the use of Valve’s Source engine that not only expands on the fluidity of character model animations and movement but allows players to interact with a myriad of objects with the advanced and realistic (to an extent) physics. Classic Headcrab Zombies are revamped and have new variants that provide players with different threats. For a story-driven FPS, Half-Life 2 is unique in its plot delivery, and making in-game mechanics feel natural, be it platforming or driving.',
            'images' => '/assets/images/games/b8c243eaa0fbac8115e0cdccac3f91dc.jpg',
            'release_date' => '2004-11-16',
            'updated' => '2024-12-31',
            'cursing' => '3899',
            'platforms' => 'PC, macOS, Xbox 360, Linux, Xbox, Android',
            'developers' => 'Valve Software, NVIDIA Lightspeed Studios',
            'genres' => 'Action, Shooter',
            'publishers' => 'Valve',
            'category_id' => 3
        ]);

        Game::create([
            'name' => 'BioShock',
            'description' => 'FPS with RPG elements, Bioshock invites players to experience horrors of underwater isolation in the city of Rapture, the failed project of the better future. After surviving the plane crash, the protagonist has only one way to go – to the giant lighthouse that opens a way to the underwater utopia. Players will have to unravel the complicated history of Rapture, relying only on themselves, their guns and Plasmids, a mystical substance, that allows it’s user to obtain near magical abilities.
            The atmosphere of isolation and threat is conveyed through the environmental sounds, subtle electrical buzzing and audio logs, telling the story of societal decay and despair. Players will shape the story, making moral choices along their way, saving Little Sisters or extracting ADAM, the mystical fuel for your abilities. While exploring the underwater city, players will complete missions for the last sane inhabitants of Rapture, while fending off the less fortunate ones.',
            'images' => '/assets/images/games/bc06a29ceac58652b684deefe7d56099.jpg',
            'release_date' => '2007-08-21',
            'updated' => '2024-12-30',
            'cursing' => '3266',
            'platforms' => 'PlayStation 3, macOS, PC, Xbox 360',
            'developers' => 'Digital Extremes, 2K Australia, 2K Marin, Irrational Games, 2K China',
            'genres' => 'Action, Shooter',
            'publishers' => '2K Games, Feral Interactive',
            'category_id' => 3
        ]);

        Game::create([
            'name' => 'Destiny 2',
            'description' => 'Destiny 2 is an online multiplayer first-person shooter. You take on the role of a Guardian that needs to protect the last city on Earth from alien invaders. The game follows its predecessor, Destiny. The goal of the game is to return the Light that was stolen from the Guardians by the aliens.
                Destiny 2 features two main activity types: player versus environment and player versus player. PvE is focused on exploration, story missions interaction with NPCs and side quests. PvP features 4v4 team matches in different modes. The game also allows taking part in group missions, such as three-player strikes and six-player raids.
                Destiny 2 has a strong RPG aspect that includes character customization and development. There are three classes in the game - Warlock, Hunter, and Titan; they provide different playstyles depending on their specialization and unique abilities. To develop the character you can gain experience points completing the story and side missions.',
            'images' => '/assets/images/games/d82990b9c67ba0d2d09d4e6fa88885a7.jpg',
            'release_date' => '2017-09-06',
            'updated' => '2024-12-29',
            'cursing' => '2611',
            'platforms' => 'PlayStation 4, Xbox One, PC, Web, Xbox Series S/X, PlayStation 5',
            'developers' => 'Bungie',
            'genres' => 'Action, Shooter',
            'publishers' => 'Activision Blizzard, Bungie',
            'category_id' => 3
        ]);

        Game::create([
            'name' => 'PAYDAY 2',
            'description' => 'The gang is back, and they have bigger and better plans. Objective based cooperative FPS became more complicated. The classic group of Hoxton, Dallas, Chains and Wolf got reinforcement, and now Payday Gang consists of 21 heisters, some of which are based on movie characters or even Youtubers. Players will be able to customize their own private arsenal, their masks, and skills, to complete the missions in their own way, be it stealthy sneak-in or full frontal assault. After completing missions, players will receive EXP points, money and a chance to get a special item that can be a gun modification, mask or a safe containing weapon skins.
                Payday 2 is a multiplayer game, meaning, that even during offline missions players will be followed by AI characters, whose loadouts, masks and perks can be customized as well. This game has been supported by the developers for many years, and amount of DLC speaks plenty of their dedication to the player base.',
            'images' => '/assets/images/games/73eecb8909e0c39fb246f457b5d6cbbe.jpg',
            'release_date' => '2013-08-13',
            'updated' => '2024-12-30',
            'cursing' => '2180',
            'platforms' => 'Linux, PC, Xbox One',
            'developers' => '505 Games, OVERKILL Software',
            'genres' => 'Action, Shooter',
            'publishers' => '505 Games, Starbreeze',
            'category_id' => 4
        ]);

        Game::create([
            'name' => 'God of War (2018)',
            'description' => 'It is a new beginning for Kratos. Living as a man outside the shadow of the gods, he ventures into the brutal Norse wilds with his son Atreus, fighting to fulfill a deeply personal quest.
                His vengeance against the Gods of Olympus years behind him, Kratos now lives as a man in the realm of Norse Gods and monsters. It is in this harsh, unforgiving world that he must fight to survive… And teach his son to do the same. This startling reimagining of God of War deconstructs the core elements that defined the series—satisfying combat; breathtaking scale; and a powerful narrative—and fuses them anew.Kratos is a father again. As mentor and protector to Atreus, a son determined to earn his respect, he is forced to deal with and control the rage that has long defined him while out in a very dangerous world with his son.',
            'images' => '/assets/images/games/4be6a6ad0364751a96229c56bf69be59.jpg',
            'release_date' => '2018-04-20',
            'updated' => '2024-12-30',
            'cursing' => '4844',
            'platforms' => 'PC, PlayStation 4',
            'developers' => 'Santa Monica Studio',
            'genres' => 'Action',
            'publishers' => 'Sony Interactive Entertainment, PlayStation PC',
            'category_id' => 4
        ]);

        Game::create([
            'name' => 'Metal Gear Solid V',
            'description' => 'Metal Gear Solid 5 continues the story of MGS: Peace Walker and MGS V: Ground Zeroes. Snake seeks revenge for the attack on the MSF group 9 years ago, that placed Big Boss into a coma. After the failed assassination attempt, Big Boss takes the code name Venom Snake, delving back into the world of superhumans and espionage.
                A large-scale story that includes 5 hours of cinematic cutscenes compliments open world exploration with hundreds of audio logs and side missions, forming the atmosphere of military drama with sci-fi elements. MGS5: Phantom Pain has an advanced AI system that will allow enemy soldiers constantly call for reinforcements if they see that something is wrong, forcing players to take down communications and fight or retreat and try again.
                Players will manage the base by gathering and managing staff, weaponry, and resources, in order to upgrade their personal arsenal and companions.',
            'images' => '/assets/images/games/49016e06ae2103881ff6373248843069.jpg',
            'release_date' => '2015-09-01',
            'updated' => '2024-12-29',
            'cursing' => '2478',
            'platforms' => 'PlayStation 4, PC, Xbox One, PlayStation 3, Xbox 360',
            'developers' => 'Kojima Productions',
            'genres' => 'Action, Shooter',
            'publishers' => 'Konami',
            'category_id' => 4
        ]);

        Game::create([
            'name' => 'Apex Legends',
            'description' => 'Conquer with character in Apex Legends, a free-to-play* Battle Royale shooter where legendary characters with powerful abilities team up to battle for fame and fortune on the fringes of the Frontier. Master an ever-growing roster of diverse legends, deep tactical squad play, and bold new innovations that level-up the Battle Royale experience—all within a rugged world where anything goes. Welcome to the next evolution of Battle Royale.
                Characters you can play as: Caustic, Bangalore, Bloodhound, Crypto, Gibraltar, Lifeline, Loba, Mirage, Octane, Pathfinder, Rampart, Revenant.',
            'images' => '/assets/images/games/737ea5662211d2e0bbd6f5989189e4f1.jpg',
            'release_date' => '2019-02-04',
            'updated' => '2024-12-31',
            'cursing' => '2359',
            'platforms' => 'PlayStation 4, Nintendo Switch, macOS, PC, Xbox One`',
            'developers' => 'Respawn Entertainment',
            'genres' => 'Action, Shooter',
            'publishers' => 'Electronic Arts',
            'category_id' => 4
        ]);

        Game::create([
            'name' => 'The Witcher: Enhanced Edition Director Cut',
            'description' => 'The Witcher is the very first instalment of the series that follows the story of Geralt from Rivia. Being found unconscious on the battlefield he must retrieve his memory and help the emperors daughter, Adda to stop her from turning in to a feral monster. Facing the biggest enemy, Salamander, Geralt must also help all the fractions around the world to find peace between each other.
                The fighting system is very flexible. Choosing from three different styles, you can adapt Geralt for any kind of a combat situation. Fast style of fighting gives you an opportunity to strike your opponents with your speed. The strong style focuses itself on destroying your enemies with powerful attacks, while sweeping style is very good when facing a number of foes. You can also craft some potions to gain important benefits such as seeing in the dark or having a larger amount HP. Plot style is unique as well. The game never gives a precise definition of evil, which leads the player to convenient situations where the choice is quite bad anyway. Enhanced edition improves every aspect of the game as graphics and the productivity of it, while Directors Cut does the same without censorship for North Americas version.',
            'images' => '/assets/images/games/ee3e10193aafc3230ba1cae426967d10.jpg',
            'release_date' => '2008-09-16',
            'updated' => '2024-12-31',
            'cursing' => '2001',
            'platforms' => 'PC, macOS',
            'developers' => 'CD PROJEKT RED',
            'genres' => 'Action, RPG',
            'publishers' => '1C-SoftClub, CD PROJEKT RED, Atari',
            'category_id' => 5
        ]);

        Game::create([
            'name' => 'Middle-earth: Shadow of Mordor',
            'description' => 'Lord of the rings franchise brought a new title to the collection, an open world action-adventure game, that follows Talion, Gondor captain, that survived the sacrifice that was meant to bring the Elf Lord Celebrimbor as a wraith. Losing his wife and his son, Talion is merged with Celebrimor, escaping death. Players will have to gain EXP in order to upgrade abilities through completing various missions and defeating Uruk warlords. Some missions might require special conditions for the greater reward.
                Shadow of Mordor implemented the Nemesis System. It tracks the progress of every special Uruk warrior. Each special Uruk has a set of strengths and weaknesses, and players can assassinate higher ranked officers in order to promote easy to defeat Uruk to defeat them at a higher rank, weakening the Sauron’s army. This planning allows players to adapt, and use mechanics of stealth kills, ranged combat, wraith skills and head-on melee more effective.',
            'images' => '/assets/images/games/d1a2e99ade53494c6330a0ed945fe823.jpg',
            'release_date' => '2014-09-30',
            'updated' => '2024-12-30',
            'cursing' => '2475',
            'platforms' => 'Linux, Xbox One, Xbox 360, PlayStation 3, PlayStation 4, macOS, PC',
            'developers' => 'Feral Interactive, Monolith Productions',
            'genres' => 'Action, RPG',
            'publishers' => 'Feral Interactive, Warner Bros. Interactive',
            'category_id' => 5
        ]);

        Game::create([
            'name' => 'The Walking Dead: Season 1',
            'description' => 'The Walking Dead is a five-part game series set in the same universe as Robert Kirkman’s award-winning comic book series. Play as Lee Everett, a convicted criminal, who has been given a second chance at life in a world devastated by the undead. With corpses returning to life and survivors stopping at nothing to maintain their own safety, protecting an orphaned girl named Clementine may offer him redemption in a world gone to hell.
                A continuing story of adventure horror spanning across 5 episodes:
                Episode 1 – A New Day (Available Now)
                Episode 2 – Starved for Help (Available Now)
                Episode 3 – Long Road Ahead (Available Now)
                Episode 4 – Around Every Corner (Available Now)
                Episode 5 – No Time Left (Available Now)
                All five episodes are now available immediately upon purchasing Season 1. Based on Robert Kirkman’s Eisner-Award winning comic book series, The Walking Dead allows gamers to experience the true horror of the zombie apocalypse
                A tailored game experience – Live with the profound and lasting consequences of the decisions that you make in each episode. Your actions and choices will affect how your story plays out across the entire series.',
            'images' => '/assets/images/games/8d69eb6c32ed6acfd75f82d532144993.jpg',
            'release_date' => '2012-04-23',
            'updated' => '2024-12-30',
            'cursing' => '2408',
            'platforms' => 'Android, PS Vita, macOS, PC, iOS, PlayStation 4, PlayStation 3, Xbox 360, Nintendo Switch, Xbox One',
            'developers' => 'Telltale Games',
            'genres' => 'Action, Adventure',
            'publishers' => 'Telltale Games',
            'category_id' => 5
        ]);

        Game::create([
            'name' => 'Team Fortress 2',
            'description' => 'TF2 is an objective based arena shooter with unique characters, representing different classes, acting as a staple of casual and competitive gaming for Steam. Dozens of different maps and game modes are trying to keep this game alive, after all the years it was available. Each character has a vast arsenal that can be accessed through completing in-game achievements, randomly receiving them from loot-boxes within the game, crafting them or just buying and trading items on the Steam Market.
                For players, thats not into the direct clash with players from the enemy team, Team Fortress 2 introduced a PvE mode, which is wave defense from the mirrored robotic opponents that have qualities of some of the playable classes.
                Every update and introduction, made over years, provided a lot of entertainment In the form of comic books an short animated videos, creating and explaining a story behind endless clashes for resources, briefcases or pure domination.',
            'images' => '/assets/images/games/46d98e6910fbc0706e2948a7cc9b10c5.jpg',
            'release_date' => '2007-10-10',
            'updated' => '2024-12-30',
            'cursing' => '2834',
            'platforms' => 'PC, macOS, Linux',
            'developers' => 'Valve Software',
            'genres' => 'Action, Shooter',
            'publishers' => 'Valve',
            'category_id' => 6
        ]);

        Game::create([
            'name' => 'Rise of the Tomb Raider',
            'description' => 'Rise of the Tomb Raider is the eleventh entry in the franchise, being a sequel to its predecessor, Tomb Raider, a reboot of the franchise. This story follows Lara Croft, one year after battling her supernatural experiences in Yamatai. This time she is trying to find the legendary city of Kitezh in Siberia, Russia. The legend behind the city begins in the 12th century and still comes nowadays, that this ancient city grants with a promise of immortality. While Lara tries to solve the mystery of Siberia, she encounters an organisation called Trinity. They want to retrieve this gift to themselves. Following the notes of her father, Lara tries to discover the secrets of the ancient city and stop Trinity in doing so.
                Exploring the Soviet motive, even more, the game has the DLCs - Baba Yaga, the Temple of the Witch, which follows Lara in the Soviet mine and confronting the legendary witch of Russian folk-tales, Cold Darkness Awakened, the story about a secret biological weapon and Blood Ties and Laras Nightmare - a fight for ownership of the Croft estate.',
            'images' => '/assets/images/games/b45575f34285f2c4479c9a5f719d972e.jpg',
            'release_date' => '2015-11-10',
            'updated' => '2024-12-30',
            'cursing' => '2705',
            'platforms' => 'Xbox One, PC, macOS, PlayStation 4',
            'developers' => 'Feral Interactive, Crystal Dynamics, Nixxes',
            'genres' => 'Action',
            'publishers' => 'Square Enix, Microsoft Studios, Feral Interactive',
            'category_id' => 6
        ]);

        Game::create([
            'name' => 'Hollow Knight',
            'description' => 'Hollow Knight is a Metroidvania-type game developed by an indie studio named Team Cherry.
                Most of the games story is told through the in-world items, tablets, and thoughts of other characters. Many plot aspects are told to the player indirectly or through the secret areas that provide a bit of lore in addition to an upgrade. At the beginning of the game, the player visits a town of Dirtmouth. A town built above the ruins of Hallownest. The players descend down into the ruins to find some answers to his questions.
                The game revolves mainly around the exploration of the in-game world, which requires the players to have some platforming skills. The players have to find secrets that are scattered around the level and battle their enemies. There is a certain degree of backtracking in the game as some areas are locked until the player defeats a certain boss or picks up a specific item. Each area changes as the plot advances so it may be surprising to come back in a certain area.
                The Protagonist uses a nail which serves as a replacement for a sword. Players can attack in four directions. The nail is upgradable.',
            'images' => '/assets/images/games/4cfc6b7f1850590a4634b08bfab308ab.jpg',
            'release_date' => '2017-02-03',
            'updated' => '2025-01-03',
            'cursing' => '2549',
            'platforms' => 'PlayStation 4, Linux, macOS, PC, Nintendo Switch, Xbox One',
            'developers' => 'Team Cherry',
            'genres' => 'Indie, Platformer',
            'publishers' => 'Team Cherry',
            'category_id' => 7,
        ]);

        Game::create([
            'name' => 'Rocket League',
            'description' => 'Highly competitive soccer game with rocket-cars is the most comprehensive way to describe this game. Technically a sequel to Psyonix’ previous game - Supersonic Acrobatic Rocket-Powered Battle-Cars; Rocket League successfully became a standalone sensation, that can be enjoyed by anyone. Easy to learn, hard to master game mechanics are perfect for the tight controls. Players are invited to maneuver the different fields within several game modes, from arcade to ranked game either 1v1, or in 2v2 and 3v3 teams. Using boosters will not only speed up the car but will allow the car to propel itself into the air.
                Rocket League provides several levels of customization, where not only the color of your car can be adjusted, but the colors and form of the booster flame, different hats, and little flags. Or players can pick a completely different car. Collaboration with different franchises brought not only original transport but some famous cars, including Batmobile or Delorian from Back to the Future.',
            'images' => '/assets/images/games/8cce7c0e99dcc43d66c8efd42f9d03e3 (1).jpg',
            'release_date' => '2015-07-07',
            'updated' => '2025-01-03',
            'cursing' => '2802',
            'platforms' => 'Nintendo Switch, Linux, macOS, Xbox One, PC, PlayStation 4',
            'developers' => 'Psyonix',
            'genres' => 'Sports, Racing, Indie',
            'publishers' => 'Psyonix',
            'category_id' => 8,
        ]);

        Game::create([
            'name' => 'Outlast',
            'description' => 'Cinematic gameplay is used to make a stylistic point, and this psychological horror game performs just that. Outlast follows the story of investigative journalist Miles Upshur, that got the lead on the inhuman experiments, performed on the asylum patients. Outlast forces players to run away from danger, simply because there is no combat system. All Miles can do is to document what is happening inside the Mount Massive Asylum. Players do not have a flashlight, only a night vision camera, which constantly requires batteries in order to function. Miles will be pursued through the halls, rooms, yards and enclosed laboratories by distressed and aggressive inhabitants. Over the course of the game, players will have to solve puzzles by locating and collecting items and travel through the Asylum with realistic movement animation and horror sting sound effect, in order to make players sympathize with the protagonists.',
            'images' => '/assets/images/games/9ddabb34840ea9227556670606cf8ea3.jpg',
            'release_date' => '2013-09-03',
            'updated' => '2025-01-03',
            'cursing' => '1782',
            'platforms' => 'Linux, macOS, Nintendo Switch, PC, Xbox One, PlayStation 4',
            'developers' => 'Red Barrels',
            'genres' => 'Action, Indie',
            'publishers' => 'Red Barrels',
            'category_id' => 9,
        ]);

        Game::create([
            'name' => 'Hotline Miami',
            'description' => 'Several chapters of top-down shooter action, Hotline Miami is a violent game, where the player takes control of the unnamed man, that receives orders to clear out stages from bandits and mobsters, using every weapon he can get. Over the course of the game, the player will be able to collect the masks that provide buffs and abilities. Fluid and tight combat includes various melee and ranged weapons, that can be used as intended or just thrown at the enemy. Once Jacket, dubbed so for his distinct letterman jacket by fans, arrives at the mission, players will have to clear out every floor from the enemies, using rooms and doors for cover or ambushes. As the story moves on, Jackets mental health will visibly deteriorate, and he will be shown to suffer from hallucinations, which is in tone with acid 80’s theme.',
            'images' => '/assets/images/games/9fa63622543e5d4f6d99aa9d73b043de.jpg',
            'release_date' => '2012-10-22',
            'updated' => '2025-01-04',
            'cursing' => '2583',
            'platforms' => 'Linux, Nintendo Switch, Xbox One, PlayStation 4, PS Vita, PC',
            'developers' => 'Devolver Digital, Dennaton Games',
            'genres' => 'Action, Shooter, Arcade, Indie',
            'publishers' => 'Devolver Digital',
            'category_id' => 10,
        ]);

        Game::create([
            'name' => 'Limbo',
            'description' => 'This popular 2D puzzle-platformer creates the atmosphere of isolation, where the player alone can guide the nameless protagonist to his destination. Hostile environments and one-hit deaths may seem difficult, but the game implements a fair amount of checkpoints. The monochrome color palette showcases cartoony proportions of every living thing while making lack of details threatening. Limbo shows you exactly what you encounter, but never how it looks.
                Limbo uses the atmosphere and sound design of the horror genre while avoiding tropes of the modern horror games. The overarching theme and unique style compensated for the rather short game with an abrupt ending, making Limbo one of the most impactful games for the genre.
                The simple controls and easy-to-pick-up mechanics help to make a clear distinction, which part of the stage players can interact with, and which part can lead to the quick death. Even though the game is in black and white, this separation is intuitive and natural, so the player would know exactly where to go or what to do.',
            'images' => '/assets/images/games/9424d6bb763dc38d9378b488603c87fa.jpg',
            'release_date' => '2010-07-21',
            'updated' => '2025-01-03',
            'cursing' => '3923',
            'platforms' => 'PC, Android, PS Vita, PlayStation 4, PlayStation 3, Xbox 360, Linux, macOS, iOS, Xbox One, Nintendo Switch',
            'developers' => 'Double Eleven, Playdead, 鱼俞',
            'genres' => 'Action, Adventure, Indie, Puzzle, Platformer',
            'publishers' => 'Microsoft Studios, Playdead, 鱼俞',
            'category_id' => 11,
        ]);

        Game::create([
            'name' => 'Terraria',
            'description' => 'Terraria is a 2D action adventure sandbox game, where players create a character and gather resources in order to gradually craft stronger weapons and armor. Players create randomly generated maps that contain different locations within it, and by gathering specific resources and triggering special events, players will fight one of the many in-game bosses. Created characters can be played on different maps.
                The game introduces hundreds of unique items that can be found across the entirety of the map, some of which may not even be encountered.
                Terraria have many different Biomes and areas with distinct visuals, containing resources and enemies unique to this biome. After gathering materials, players can craft furniture, and build settlements and houses, since after completing events or finding specific items NPCs will start to arrive, and will require player’s protection. Terraria can be played on three difficulties and has a large modding community.',
            'images' => '/assets/images/games/f466571d536f2e3ea9e815ad17177501 (1).jpg',
            'release_date' => '2011-05-16',
            'updated' => '2025-01-03',
            'cursing' => '2384',
            'platforms' => 'Xbox 360, Wii U, Nintendo 3DS, Xbox One, PlayStation 4, iOS, PC, macOS, Linux, Nintendo Switch, PlayStation 3, PS Vita, Android',
            'developers' => 'Engine Software, Codeglue, Pipeworks Studio, Re-Logic',
            'genres' => 'Action, Indie, Platformer',
            'publishers' => '505 Games, Headup Games, Spike Chunsoft, Re-Logic',
            'category_id' => 12,
        ]);

        Game::create([
            'name' => 'Limbo',
            'description' => 'This popular 2D puzzle-platformer creates the atmosphere of isolation, where the player alone can guide the nameless protagonist to his destination. Hostile environments and one-hit deaths may seem difficult, but the game implements a fair amount of checkpoints. The monochrome color palette showcases cartoony proportions of every living thing while making lack of details threatening. Limbo shows you exactly what you encounter, but never how it looks.
                Limbo uses the atmosphere and sound design of the horror genre while avoiding tropes of the modern horror games. The overarching theme and unique style compensated for the rather short game with an abrupt ending, making Limbo one of the most impactful games for the genre.
                The simple controls and easy-to-pick-up mechanics help to make a clear distinction, which part of the stage players can interact with, and which part can lead to the quick death. Even though the game is in black and white, this separation is intuitive and natural, so the player would know exactly where to go or what to do.',
            'images' => '/assets/images/games/9424d6bb763dc38d9378b488603c87fa.jpg',
            'release_date' => '2010-07-21',
            'updated' => '2025-01-03',
            'cursing' => '3923',
            'platforms' => 'PC, Android, PS Vita, PlayStation 4, PlayStation 3, Xbox 360, Linux, macOS, iOS, Xbox One, Nintendo Switch',
            'developers' => 'Double Eleven, Playdead, 鱼俞',
            'genres' => 'Action, Adventure, Indie, Puzzle, Platformer',
            'publishers' => 'Microsoft Studios, Playdead, 鱼俞',
            'category_id' => 15,
        ]);

        Game::create([
            'name' => 'Little Nightmares',
            'description' => 'Heavily inspired by Limbo and Inside, Little Nightmares are telling a story of another lost child. Six is a starving little girl in a yellow raincoat, which is trapped in a mysterious vessel named the Maw. Players are taking control of Six’s movement, in order to help her escape the ship and dangerous inhabitants, that’s been kidnaping and preparing children to be served as a feast for the Guests.
                The control scheme is not including any combat moves, leaving players defenseless against any threat. Six can run, crawl, climb, push or pull, and in rare cases carry an object she can throw to stagger an enemy or solve a puzzle. The game gives players the ability to carry a lighted match at any time, inviting players to explore and search for the collectible statues.
                Little Nightmares have 3 DLC levels, expanding the game beyond the perspective of Six, where the Runaway Kid, a young boy, who is trying to catch up to Six and having his own adventure, going through the Maw in the extra chapters, named “The Depths”, “The Hideaway” and “The Residence.”',
            'images' => '/assets/images/games/8a02f84a5916ede2f923b88d5f8217ba.jpg',
            'release_date' => '2017-04-27',
            'updated' => '2025-01-02',
            'cursing' => '1560',
            'platforms' => 'iOS, PlayStation 4, PC, Xbox One, Nintendo Switch',
            'developers' => 'BANDAI NAMCO Entertainment America, Playdigious, Tarsier Studios',
            'genres' => 'Action, Adventure, Platformer',
            'publishers' => 'Bandai Namco Entertainment, BANDAI NAMCO Entertainment US, Playdigious',
            'category_id' => 15,
        ]);

        Game::create([
            'name' => 'Garrys Mod',
            'description' => 'Garrys Mod or simply GMod is a source-engine based modification that now works as a standalone game. With no plot or exact gameplay at all, anyone can create his own game mode to play for fun. You can find anything youre into. Trouble In Terrorist Town, Prop Hunt, Hunger Games, Franchise-based modes such as Star Wars or Lord of the Rings - anything.
                Basically, GMod stands for God Mode in video games, because you can play with any asset of the source engine. Try out physics, characters, maps, weaponry - anything. Based on that, Garrys Mod gives players quite a variety of mods to spend their time. It doesnt sound so earnestly. You will probably find something that will provide you with quite a good amount of fun. Servers are specifically sorted in game modes so youll never play a different mode while playing exact one what you wanted. At the end of the day, this game is about receiving as much fun from what is happening around you as possible.',
            'images' => '/assets/images/games/48cb04ca483be865e3a83119c94e6097.jpg',
            'release_date' => '2004-12-24',
            'updated' => '2024-12-3',
            'cursing' => '1576',
            'platforms' => 'Linux, macOS, PC',
            'developers' => 'Facepunch Studios',
            'genres' => 'Action, Adventure, Simulation, Casual, Indie',
            'publishers' => 'Valve',
            'category_id' => 15,
        ]);

        Game::create([
            'name' => 'Amnesia: The Dark Descent',
            'description' => 'Carefully constructed horror game relies on positioning, camera work, and shocking content. But Amnesia: The Dark Descent adds psychological elements to it. Players control the young man named Daniel, who wakes up in a seemingly empty castle, alone and with a massive memory loss. Through environmental storytelling, notes, audio logs and even visions, players are invited to uncover the deep-rooted secrets of the castle.
                Throughout the game players will be introduced to the mechanics of Sanity, representing the mental state of Daniel which can be affected by lack of light, visions and even unpleasant encounters with the monsters. When decreased, Sanity will distort the vision of the player to a different and seemingly random effect, in order to depict actual effects of severe anxiety. Most of the game challenges are completed through the item search and physics puzzles, forcing players to be resourceful and courageous.
                The game supports modding, and allows user-created content alongside the free DLC Justine, telling a story of a female prisoner. Given how short the DLC story is - several possible endings are available.',
            'images' => '/assets/images/games/b54598d1d5cc31899f4f0a7e3122a7b0.jpg',
            'release_date' => '2010-09-08',
            'updated' => '2024-12-3',
            'cursing' => '1207',
            'platforms' => 'Linux, macOS, PC',
            'developers' => 'Frictional Games',
            'genres' => 'Action, Adventure, Indie',
            'publishers' => 'Frictional Games',
            'category_id' => 15,
        ]);

        Game::create([
            'name' => 'Warframe',
            'description' => 'Warframe is an online free-to-play cooperative third-person looter shooter. In the far future the Orokin had absolute control over the solar system but have since disappeared, now the militaristic Grineer, the money-worshipping Corpus, and the Infested fight for what they left behind. You are a Tenno - a master of gun and blade and user of the Warframes, it is up to you to bring back balance to the system from within, while also fighting a new threat from without: the Sentients.
                Over 40 unique Warframes to build, hundreds of guns and melee weapons to utilize, and various pet companions to help you along the way - all of which can be crafted for free and enhanced by an in-depth modding system.
                With constant updates by Digital Extremes, the game now has over six years of updates including new open-world landscapes (Plains of Eidolon-2017, Orb Vallis-2018) and cinematic story expansions (The Second Dream-2015, The War Within-2016, The The Sacrifice-2018) with more content being added every year.',
            'images' => '/assets/images/games/f87457e8347484033cb34cde6101d08d.jpg',
            'release_date' => '2013-03-25',
            'updated' => '2024-12-3',
            'cursing' => '2070',
            'platforms' => 'iOS, Xbox Series S/X, PlayStation 5, PlayStation 4, Xbox One, Nintendo Switch, PC',
            'developers' => 'Digital Extremes, Panic Button',
            'genres' => 'Action, Shooter, RPG, Massively Multiplayer',
            'publishers' => 'Digital Extremes',
            'category_id' => 16,
        ]);


        Game::create([
            'name' => 'Cyberpunk 2077',
            'description' => 'The game is set in the year 2077 in a fictional futuristic metropolis Night City in California. In the world of the game, there are developed cybernetic augmentations that enhance peoples strength, agility, and memory. The city is governed by corporations. Many jobs are taken over by the robots, leaving a lot of people poor and homeless. Night City has a roaring underworld, with black markets, underground surgeons, drug dealers, and street gangs abound.
                The main protagonist is fully customizable, including his or her sex and appearance, and goes by the nickname V. He or she is an underground mercenary who does “dirty business” for the various contractors. An NPC companion named Jackie joins the protagonist early at the game, and various other companions may join the player on certain missions as the plot demands. However, the game has no parties and no companion system.
                The player controls V from the first person view, with the third-person view used for cutscenes only. The protagonist can travel across the city on feet or using various vehicles, in a manner some observers compared to GTA series. There are many options for the character customization, including three character classes, and a variety of augmentations V can install to enhance his or her abilities.',
            'images' => '/assets/images/games/26d4437715bee60138dab4a7c8c59c92.jpg',
            'release_date' => '2020-12-10',
            'updated' => '2025-01-04',
            'cursing' => '2738',
            'platforms' => 'PlayStation 4, PC, Xbox Series S/X, PlayStation 5, Xbox One',
            'developers' => 'CD PROJEKT RED, CD PROJEKT',
            'genres' => 'Action, Shooter, RPG',
            'publishers' => 'CD PROJEKT RED',
            'category_id' => 16,
        ]);


        Game::create([
            'name' => 'Company of Heroes 2',
            'description' => 'Company of Heroes 2 is the second installment in the series of real-time strategy games, following its predecessor’s legacy as one of the most complex and realistic WWII simulators. New features and game engine improvements will provide the most intense experience of the most significant battles of both the Western and Eastern fronts of the war.
                After seven years since the first game’s release, Company of Heroes 2 provides the players with new battle mechanics, even more, micromanagement and new game modes, as well as an expanded single-player campaign, taking place in the Eastern front. The key features of the first game, being the dynamic environments and cover system, have also been overhauled, with additions as a line of sight for every troop. The warfare itself has also been changed, removing the mechanics of doctrines and adding traits to various generals on the field.
                The game also includes additional content, which adds two new Allied factions, the US expeditionary forces and the Royal Army, and new campaigns for both factions, while also improving performance and adding new features to the game, such as tech trees, various tactics and many more.',
            'images' => '/assets/images/games/0bd5646a3d8ee0ac3314bced91ea306d.jpg',
            'release_date' => '2013-06-25',
            'updated' => '2025-01-03',
            'cursing' => '857',
            'platforms' => 'Linux, macOS, PC',
            'developers' => 'Feral Interactive, Relic Entertainment',
            'genres' => 'Strategy',
            'publishers' => 'SEGA, Feral Interactive',
            'category_id' => 10,
        ]);


        Game::create([
            'name' => 'Cities: Skylines',
            'description' => 'Cities: Skylines is a traditional city-building game, which allows players to experience urban planning in all aspects including zoning, road placement, transportation, taxation, and improvement of welfare. Therefore, within the game players are able to assume roles of city’s principal architect and mayor. The history of the city, in control of the player, begins with the 2-by-2 kilometers plot of land and a sum of money to start with. Players have to zone the city, build roads, explore the surroundings, provide infrastructure and jobs to attract new citizens. Once the newcomers settle down, the immediate reaction is expected to establish  services and to set proper taxes. Progressing within the game and developing the city will unlock new upgrades of the urban environment and lead to the territorial expansion. The gameplay also requires the control of several city’s parameter scales like budget, health, employment, and pollution. The game also features a creative sandbox mode, where the architect’s imagination is not restricted in any way.',
            'images' => '/assets/images/games/25c4776ab5723d5d735d8bf617ca12d9.jpg',
            'release_date' => '2015-03-10',
            'updated' => '2025-01-03',
            'cursing' => '1494',
            'platforms' => 'Xbox One, PC, macOS, Linux, Nintendo Switch, PlayStation 4',
            'developers' => 'Colossal Order',
            'genres' => 'Strategy, Simulation',
            'publishers' => 'Paradox Interactive',
            'category_id' => 10,
        ]);


        Game::create([
            'name' => 'Sid Meiers Civilization V',
            'description' => 'Real-time strategy genre has always been about domination over your opponent, and Civilization in general expanded on the concept. Civilization 5 allows players to pick one of the 43 civilizations available in, including DLCs and the expansions. After that players in single player or multiplayer games will place their first cities, which will act as capital, and begin the race. In order to win, players will have to meet one of the following conditions:
                - defeating every other existing nation through combat to get Domination Victory;
                - building and launching a spaceship to get Science victory;
                - completing the Utopia project by filling out 5 trees of social policies, to get Social Victory;
                - winning a vote after establishing the United Nations, to get the Diplomatic victory;
                - getting the highest score at the end of the time period, if no other win condition was reached, to get Time Victory.
            Every civilization is represented by one of the most influential historical figures and voiced in the language of that nation. Easy to pick up game mechanics of research, foraging, and building, allow the player to immerse themselves into the game atmosphere of continuous development.',
            'images' => '/assets/images/games/55ee6432ac2bf224610fa17e4c652107.jpg',
            'release_date' => '2010-09-21',
            'updated' => '2025-01-03',
            'cursing' => '1970',
            'platforms' => 'PC, macOS, Linux',
            'developers' => 'Aspyr Media, Firaxis',
            'genres' => 'Strategy',
            'publishers' => '2K Games, Aspyr',
            'category_id' => 10,
        ]);


        Game::create([
            'name' => 'ARK: Survival Of The Fittest',
            'description' => 'Welcome to ARK: Survival of the Fittest, the first ever M.O.S.A. - a Multiplayer Online Survival Arena - that Studio Wildcard designed for the burgeoning wild west of eSports. A spin-off from the most popular open-world Early Access game on Steam ARK: Survival Evolved, ARK: Survival of the Fittest (SotF) pits up to 72 combatants in an action-packed struggle for survival where players are ultimately pushed into an epic final showdown where only one “Tribe” will make it out alive.
                Survivors can form one- to six-person Tribes with the options to choose Unofficial and Official (Ranked) servers, and a variety of game-lengths and sizes in which to play. Players will start in the base forest environment introduced in the original ARK: Survival Evolved, with new environments and creatures introduced as the game evolves. Dedicated eSport ranking, matchmaking, reward, and tournament features make ARK: SotF readily accessible to all players.
                Balanced for intense competition, contestants begin in a neutral staging area where they can communicate pre-game, strategize, or talk trash. After a count-down, they dramatically descend from the sky onto the ARK in a circular formation via beams of light. There is a cache of valuable items in the center – do survivors dash for the goods and fight it out, do they run into the forest and hide, search for Dinosaurs to rapidly build their army, or do they freeze up from the sheer terror of death? A continually shrinking “ring of death” forces contestants ever closer together over time. The hunt is on!
                KEY FEATURES
                Action-Packed Core Survival Gameplay
                30+ Creatures to Tame and Ride at Early Access Start, Many more planned at full launch
                Multiple game modes (1v1, 2v2, 4v4, and 6v6)
                One-to-Six Player Tribes
                Variable game configurations ranging from 30-minute “instant action” to three-hour long “epic wars”
                Top-ranked players are listed dynamically on SurviveTheArk.com and are provided monthly prize packages!
                Game-Changing Tameable Super Creatures (Dragon, Giant Ape, Brood Mother)
                Random “Evolution Events”
                Arsenal of Weapons, Traps, Armor, Structures and other Items from Primitive to Modern Tech Tiers
                Robust Ranking, Tournament & Spectator Features
                Exclusive SotF Cosmetic Items that can also be used in ARK: Survival Evolved
                Custom-Painted “War Banners” enable Tribes to show off their team spirit on Flags across their army of Dinosaurs, and are also broadcast on the gigantic billboards during game events. Just don’t draw anything offensive!
                A custom soundtrack written by award-winning composer Gareth Coker of Ori and the Blind Forest!',
            'images' => '/assets/images/games/0953bf01cd4e4dd204aba85489ac9868.jpg',
            'release_date' => '2016-03-15',
            'updated' => '2024-12-31',
            'cursing' => '513',
            'platforms' => 'Android, Linux, macOS, PC, iOS',
            'developers' => 'Instinct Games, Studio Wildcard, Efecto Studios, Virtual Basement',
            'genres' => 'Action, RPG, Strategy, Massively Multiplayer, Indie',
            'publishers' => 'Studio Wildcard, Wildcard Properties',
            'category_id' => 10,
        ]);


        Game::create([
            'name' => 'XCOM: Enemy Unknown',
            'description' => 'Any alien invasion meets resistance in some form, so in this reboot of the series, players will take the mantle of the XCOM commander, and control the elite scientists and soldiers, in order to stop the threat. After successfully neutralizing scout ships, securing the crash site and retrieving civilians, XCOM personnel, and alien corpses, it’s clear that all of them are genetically and cybernetically altered, which starts the beginning of the arms race with the invaders.
                During the missions X-COM: Enemy Unknown is a turn-based tactical game, while in the downtime players will direct the organization, form units, oversee the research, expand the base of operations and manage resources. Complex combat consists of units taking turns to perform their actions with a top-down view of the battlefield. XCOM soldiers and aliens can take cover during battles, and miss their shots and attacks if anything affects their accuracy. Over the course of the game, players will be able to gain access to new technology while encountering new varied enemy types.',
            'images' => '/assets/images/games/2383a172b4d50a7b44e07980eb7141ea.jpg',
            'release_date' => '2012-10-09',
            'updated' => '2024-12-30',
            'cursing' => rand(450, 7500),
            'platforms' => 'PC, Android, iOS, Xbox 360, PlayStation 3, macOS',
            'developers' => 'Feral Interactive, 2K, Firaxis',
            'genres' => 'Strategy',
            'publishers' => '2K Games, Feral Interactive',
            'category_id' => 10,
        ]);


        Game::create([
            'name' => 'Brutal Legend',
            'description' => 'Heavy Metal is a way of life and a world in itself, but Eddie Riggs found the real one, after the accident during a concert left him crushed by the scenery and making the involuntary blood sacrifice to the Ormagöden. The action adventure game with the real-time strategy elements in the open world introduced a star voice cast, compiled by musicians that became prototypes for some of the characters players will encounter during the game. Aside from the main story, players will be able to encounter dozens of side missions that may vary from the defense battles to a race. When using his V-guitar named Clementine, Eddie can cast spells, called Solos, by a simple rhythm game, reminiscent of Guitar Hero. Some story missions are so-called Battles of the Bands, where players will fight the armies in a real-time strategy fashion, and winning by outperforming the enemy band and destroying the stage.',
            'images' => '/assets/images/games/af7a831001c5c32c46e950cc883b8cb7.jpg',
            'release_date' => '2009-10-12',
            'updated' => '2024-12-30',
            'cursing' => rand(450, 7500),
            'platforms' => 'Xbox 360, PlayStation 3, Xbox One, iOS, PC, Linux, macOS',
            'developers' => 'Electronic Arts, Double Fine Productions',
            'genres' => 'Action, Strategy',
            'publishers' => 'Electronic Arts, Microsoft Studios, Double Fine Productions',
            'category_id' => 10,
        ]);


        Game::create([
            'name' => 'Wallpaper Engine',
            'description' => '• Bring your desktop wallpapers alive with realtime graphics, videos, applications or websites.
                • Use animated screensavers while you are away from your computer.
                • Personalize animated wallpapers with your favorite colors.
                • Use interactive wallpapers that can be controlled with your mouse.
                • Many aspect ratios and native resolutions supported including 16:9, 21:9, 16:10, 4:3.
                • Multi monitor environments are supported.
                • Wallpapers will pause while playing games to save performance.
                • Create your own animated wallpapers in the Wallpaper Engine Editor.
                • Animate new live wallpapers from basic images or import HTML or video files for the wallpaper.
                • Use the Steam Workshop to share and download wallpapers for free.
                • Wallpaper Engine can be used at the same time as any other Steam game or application.
                • Supported video formats: mp4, WebM, avi, m4v, mov, wmv (for local files, Workshop only allows mp4).
                • Use the free Android companion app to take your favorite scene and video wallpapers on the go.
                • Support for Razer Chroma and Corsair iCUE.',
            'images' => '/assets/images/games/5a72aed79451d8fbd6a7b82f784002bd.jpg',
            'release_date' => '2016-10-10',
            'updated' => '2025-01-02',
            'cursing' => rand(450, 7500),
            'platforms' => 'Android, PC',
            'developers' => 'Electronic Arts, Double Fine Productions',
            'genres' => 'Casual',
            'publishers' => 'Electronic Arts, Microsoft Studios, Double Fine Productions',
            'category_id' => 7,
        ]);

        Game::create([
            'name' => 'Fall Guys: Ultimate Knockout',
            'description' => 'Fall Guys: Ultimate Knockout flings hordes of contestants together online in a mad dash through round after round of escalating chaos until one victor remains! Battle bizarre obstacles, shove through unruly competitors, and overcome the unbending laws of physics to avoid both humiliation and elimination. Leave your dignity at the door and prepare for hilarious failure in your quest for the crown!
                Massive Online Pandemonium: Dive into a series of ridiculous challenges and wild obstacle courses with 100 competitors online, all with the hopes of making the cut and advancing to the next round of mayhem.
                Competitive & Cooperative: Shift between brutally competitive free-for-alls and cooperative challenges where only the winning team advance to the next round!
                Comically Physical: Watch in delight as your fellow competitors bend, bounce, and bash their way to hilarious, physics-based failure!
                Delightfully Customizable: Fail in style with everything from fashionable pineapple couture to the latest in bunny hats available to customize your look in Fall Guys.',
            'images' => '/assets/images/games/5eb49eb2fa0738fdb5bacea557b1bc57.jpg',
            'release_date' => '2020-08-04',
            'updated' => '2025-01-03',
            'cursing' => rand(450, 7500),
            'platforms' => 'Xbox One, PlayStation 4, PC, Nintendo Switch, Xbox Series S/X',
            'developers' => 'Mediatonic',
            'genres' => 'Action, Sports, Casual, Massively Multiplayer, Indie',
            'publishers' => 'Devolver Digital',
            'category_id' => 7,
        ]);

        Game::create([
            'name' => 'Brawlhalla',
            'description' => 'Brawlhalla is a free-to-play fighting game with platformer elements. You pick a character from 39 available heroes (this amount is increasing with new updates) and try to knock your opponent off the stage. The controls are simple to make the game easy to master. Every character has two weapons and also can use boosts that drop on the stage. They also have such characteristics as Strength, Dexterity, Defense, and Speed that determine their combat style and can be slightly modified. 
                Brawlhalla supports online and local multiplayer and cooperative along with multiple modes where you can test your skills and increase the rank. Except for 1v1 duels and different team matches, you can take part in huge arena battles with multiple opponents. Some stages consist of several platforms that can change their position during the fight. Moreover, Brawlhalla holds numerous competitions and tournaments all over the world with money prizes.',
            'images' => '/assets/images/games/35b47c4d85cd6e08f3e2ca43ea5ce7bb.jpg',
            'release_date' => '2014-04-30',
            'updated' => '2024-12-30',
            'cursing' => rand(450, 7500),
            'platforms' => 'Xbox One, Android, iOS, PC, macOS, Nintendo Switch, PlayStation 4',
            'developers' => 'Ubisoft, Blue Mammoth Games',
            'genres' => 'Action, Casual, Fighting, Indie',
            'publishers' => 'Ubisoft Entertainment, Blue Mammoth Games',
            'category_id' => 7,
        ]);

        Game::create([
            'name' => 'Garrys Mod',
            'description' => 'Garrys Mod or simply GMod is a source-engine based modification that now works as a standalone game. With no plot or exact gameplay at all, anyone can create his own game mode to play for fun. You can find anything youre into. Trouble In Terrorist Town, Prop Hunt, Hunger Games, Franchise-based modes such as Star Wars or Lord of the Rings - anything.
                Basically, GMod stands for God Mode in video games, because you can play with any asset of the source engine. Try out physics, characters, maps, weaponry - anything. Based on that, Garrys Mod gives players quite a variety of mods to spend their time. It doesnt sound so earnestly. You will probably find something that will provide you with quite a good amount of fun. Servers are specifically sorted in game modes so youll never play a different mode while playing exact one what you wanted. At the end of the day, this game is about receiving as much fun from what is happening around you as possible.',
            'images' => '/assets/images/games/48cb04ca483be865e3a83119c94e6097 (1).jpg',
            'release_date' => '2004-12-24',
            'updated' => '2024-12-30',
            'cursing' => rand(450, 7500),
            'platforms' => 'Linux, macOS, PC',
            'developers' => 'Facepunch Studios',
            'genres' => 'Action, Adventure, Simulation, Casual, Indie',
            'publishers' => 'Valve',
            'category_id' => 7,
        ]);

        Game::create([
            'name' => 'Goat Simulator',
            'description' => 'Goat Simulator is a game that mainly can be described as a crazy one. It does not have a specific story, and there is no central villain. It is illogical, besides there are lots of bugs. But playing in it, you catch unbridled pleasure, looking at how the goat is trying to destroy everything around, using a great variety of funny and unforgettable tricks, what makes the game curious, but very rich.
                You play as a goat, whose purpose is to cause the highest damage to the world. Destroy the gas station, the car, the cottage in the vastness of the whole of the suburban district, but do it with style and taste, for example, do a backflip, and at the same time, chuck the basket so it will fly out of the window. Thus, after every perfect and crazy action, you will be rewarded with some points and bonuses!
                Also, you could use the Steam Workshop and create your goats, levels, missions, and more!',
            'images' => '/assets/images/games/a444a7628bdb49b24d06a7672f805814.jpg',
            'release_date' => '2014-04-01',
            'updated' => '2024-12-29',
            'cursing' => rand(450, 7500),
            'platforms' => 'Xbox One, Xbox 360, PlayStation 3, PlayStation 4, Android, iOS, macOS, Linux, PC',
            'developers' => 'Double Eleven, Coffee Stain Studios, Coffee Stain Publishing',
            'genres' => 'Action, Simulation, Casual, Indie',
            'publishers' => 'Coffee Stain Studios, Double Eleven',
            'category_id' => 7,
        ]);

        Game::create([
            'name' => 'Among Us',
            'description' => 'Join your crewmates in a multiplayer game of teamwork and betrayal!
                Play online or over local wifi with 4-10 players as you attempt to hold your spaceship together and return back to civilization. But beware...as there may be an alien impostor aboard!
                One crewmate has been replaced by a parasitic shapeshifter. Their goal is to eliminate the rest of the crew before the ship reaches home. The Impostor will sabotage the ship, sneak through vents, deceive, and frame others to remain anonymous and kill off the crew.
                While everyone is fixing up the ship, no one can talk to maintain anonymity. Once a body is reported, the surviving crew will openly debate who they think The Impostor is. The Impostor goal is to pretend that they are a member of the crew. If The Impostor is not voted off, everyone goes back to maintaining the ship until another body is found. If The Impostor is voted off, the crew wins!',
            'images' => '/assets/images/games/e74458058b35e01c1ae3feeb39a3f724.jpg',
            'release_date' => '2018-07-25',
            'updated' => '2025-01-02',
            'cursing' => rand(450, 7500),
            'platforms' => 'Android, Nintendo Switch, PC, iOS, PlayStation 4, PlayStation 5, Xbox One',
            'developers' => 'Innersloth',
            'genres' => 'Action, Simulation, Casual',
            'publishers' => 'Innersloth',
            'category_id' => 7,
        ]);

        Game::create([
            'name' => 'Cities: Skylines',
            'description' => 'Cities: Skylines is a traditional city-building game, which allows players to experience urban planning in all aspects including zoning, road placement, transportation, taxation, and improvement of welfare. Therefore, within the game players are able to assume roles of city’s principal architect and mayor. The history of the city, in control of the player, begins with the 2-by-2 kilometers plot of land and a sum of money to start with. Players have to zone the city, build roads, explore the surroundings, provide infrastructure and jobs to attract new citizens. Once the newcomers settle down, the immediate reaction is expected to establish  services and to set proper taxes. Progressing within the game and developing the city will unlock new upgrades of the urban environment and lead to the territorial expansion. The gameplay also requires the control of several city’s parameter scales like budget, health, employment, and pollution. The game also features a creative sandbox mode, where the architect’s imagination is not restricted in any way.',
            'images' => '/assets/images/games/25c4776ab5723d5d735d8bf617ca12d9.jpg',
            'release_date' => '2015-03-10',
            'updated' => '2025-01-03',
            'cursing' => '1494',
            'platforms' => 'Xbox One, PC, macOS, Linux, Nintendo Switch, PlayStation 4',
            'developers' => 'Colossal Order',
            'genres' => 'Strategy, Simulation',
            'publishers' => 'Paradox Interactive',
            'category_id' => 17,
        ]);

        Game::create([
            'name' => 'Garrys Mod',
            'description' => 'Garrys Mod or simply GMod is a source-engine based modification that now works as a standalone game. With no plot or exact gameplay at all, anyone can create his own game mode to play for fun. You can find anything youre into. Trouble In Terrorist Town, Prop Hunt, Hunger Games, Franchise-based modes such as Star Wars or Lord of the Rings - anything.
                Basically, GMod stands for God Mode in video games, because you can play with any asset of the source engine. Try out physics, characters, maps, weaponry - anything. Based on that, Garrys Mod gives players quite a variety of mods to spend their time. It doesnt sound so earnestly. You will probably find something that will provide you with quite a good amount of fun. Servers are specifically sorted in game modes so youll never play a different mode while playing exact one what you wanted. At the end of the day, this game is about receiving as much fun from what is happening around you as possible.',
            'images' => '/assets/images/games/48cb04ca483be865e3a83119c94e6097 (1).jpg',
            'release_date' => '2004-12-24',
            'updated' => '2024-12-30',
            'cursing' => rand(450, 7500),
            'platforms' => 'Linux, macOS, PC',
            'developers' => 'Facepunch Studios',
            'genres' => 'Action, Adventure, Simulation, Casual, Indie',
            'publishers' => 'Valve',
            'category_id' => 17,
        ]);

        Game::create([
            'name' => 'Hitman',
            'description' => 'Hitman is a six episodes game with different contracts. The action takes place as a prequel to Hitman: Agent 47 (only prologue) and episodes take place six years after Hitman: Absolution. All contracts are being ordered by a "shadow client" and seem to be unrelated. But as you fulfil those contracts, you start to realise that all of the targets somehow are a part of a secret organisation called the Providence.
                While playing Agent 47, you have a large amount of free will in completing those contracts. The main target is all that matters, and you can do anything to kill this person in your style and fashion. You can disguise as a different person and infiltrate secured area to perform the kill manually or use a long-range sniper rifle to do the trick. Your surroundings help you a lot as well by listening to nearby chat or news reports. Players are given as much freedom as possible to find your professional style in the art of killing. A large amount of DLC and expanded missions can either give you gimmick-based contracts and travel to Japan, Serbia and other countries.',
            'images' => '/assets/images/games/16b1b7b36e2042d1128d5a3e852b3b2f.jpg',
            'release_date' => '2016-03-11',
            'updated' => '2025-01-03',
            'cursing' => rand(450, 7500),
            'platforms' => 'PlayStation 4, Linux, macOS, PC, Xbox One',
            'developers' => 'Feral Interactive, Square Enix, IO Interactive',
            'genres' => 'Action, Shooter, Simulation',
            'publishers' => 'Square Enix, Feral Interactive, Warner Bros. Interactive',
            'category_id' => 17,
        ]);

        Game::create([
            'name' => 'Stardew Valley',
            'description' => 'The hero (in the beginning you can choose gender, name and appearance) - an office worker who inherited an abandoned farm. The landscape of the farm can also be selected. For example, you can decide whether there will be a river nearby for fishing.
                The farm area needs to be cleared, and it will take time.
                The hero has many different activities: plant and care for plants, raise livestock, practice crafts, extract ore, and also enter into relationships with residents of the neighbouring town to earn game money. Relationships with characters include communication, performing tasks for money, exchanging, searching for fossils and even military actions and marrying. The character is limited by the reserve of strength and health - both parameters are visible on the screen, and the game automatically puts the hero to rest if the limit of his capabilities is close. The game does not set any ultimate or primary goal, its many possibilities are designed for an unlimited time.',
            'images' => '/assets/images/games/713269608dc8f2f40f5a670a14b2de94.jpg',
            'release_date' => '2016-02-25',
            'updated' => '2025-01-02',
            'cursing' => rand(450, 7500),
            'platforms' => 'Nintendo Switch, Xbox One, PC, iOS, macOS, Linux, PlayStation 4, PS Vita, Android',
            'developers' => 'Chucklefish, ConcernedApe',
            'genres' => 'RPG, Simulation, Indie',
            'publishers' => 'Chucklefish, ConcernedApe',
            'category_id' => 17,
        ]);

        Game::create([
            'name' => 'Minecraft',
            'description' => 'One of the most popular games of the 2010s, Minecraft allows you to rebuild the environment around you. The world of the game is open, infinitely wide, and procedurally generated. It is composed of small 3D cubes that represent specific types of materials or terrain. The gameplay is centered on mining and building various structures of your choice. You can also craft items like tools, weapons, and armor. Theres an option to shift to the first or the third person view.
                Minecraft includes multiple modes that dramatically change the focus of the game. Survival and Adventure modes require the player to gather resources, hunt for food and fight monsters to survive. In the Hardcore mode, there’s even permanent death. Creative mode, by contrast, offers you to freely explore the world and construct whatever you want with unlimited resources. There’s also a multiplayer mode that allows the players to share their worlds and engage in the traditional MMO activities, such as player-vs-player combat.
                Minecrafts crude visual style, reminiscent of Lego cubes, became an iconic part of the popular culture. There are many myths and fan fiction surrounding the game, such as the legend of Herobrine, a rumored character that officially doesn’t exist.',
            'images' => '/assets/images/games/b4e4c73d5aa4ec66bbf75375c4847a2b.jpg',
            'release_date' => '2009-05-10',
            'updated' => '2025-01-04',
            'cursing' => rand(450, 7500),
            'platforms' => 'Android, PS Vita, PlayStation 4, PlayStation 3, Xbox 360, Nintendo 3DS, Nintendo Switch, macOS, PC, iOS, Wii U, Xbox One, Linux',
            'developers' => '4J Studios, Mojang',
            'genres' => 'Action, Simulation, Arcade, Massively Multiplayer, Indie',
            'publishers' => 'Microsoft Studios, Mojang',
            'category_id' => 17,
        ]);

        Game::create([
            'name' => 'Dont Starve Together',
            'description' => 'Dont Starve Together is surrealistic and grim survival game made up for six people simultaneously. Initially, Dont Starve is a single-player game with a core mechanic of going through various problems of your character. You have to sleep and eat well. Also, you have to keep your mental health all right and dont go completely mad at a situation, when these dreadful and twisted creatures are running towards you to tear apart. It seems like the world of Dont Starve is heavily inspired by Tim Burton, having a very grotesque yet creepy and bizarre-looking monsters and locations with an atmospheric soundtrack.
                While heading to multiplayer, you will experience every single problem from a singles game. The game exploits pretty similar mechanic to Minecraft - randomly generated world, surviving as a top priority for the gamer. With the only difference - if you die, you die. Permanent death of your characters increases the grim and tense atmosphere of the game itself, making the process challenging and creepy. Just remember. Dont Starve.',
            'images' => '/assets/images/games/dd50d4266915d56dd5b63ae1bf72606a.jpg',
            'release_date' => '2016-04-21',
            'updated' => '2024-12-29',
            'cursing' => rand(450, 7500),
            'platforms' => 'Linux, Xbox One, PlayStation 4, macOS, PC',
            'developers' => 'Klei Entertainment',
            'genres' => 'Action, Simulation, Indie',
            'publishers' => 'Klei Entertainment',
            'category_id' => 17,
        ]);

        Game::create([
            'name' => 'Portal 2',
            'description' => 'Portal 2 is a first-person puzzle game developed by Valve Corporation and released on April 19, 2011 on Steam, PS3 and Xbox 360. It was published by Valve Corporation in digital form and by Electronic Arts in physical form.
                Its plot directly follows the first games, taking place in the Half-Life universe. You play as Chell, a test subject in a research facility formerly ran by the company Aperture Science, but taken over by an evil AI that turned upon its creators, GladOS. After defeating GladOS at the end of the first game but failing to escape the facility, Chell is woken up from a stasis chamber by an AI personality core, Wheatley, as the unkempt complex is falling apart. As the two attempt to navigate through the ruins and escape, they stumble upon GladOS, and accidentally re-activate her...
                Portal 2s core mechanics are very similar to the first games ; the player must make their way through several test chambers which involve puzzles. For this purpose, they possess a Portal Gun, a weapon capable of creating teleportation portals on white surfaces. This seemingly simple mechanic and its subtleties coupled with the many different puzzle elements that can appear in puzzles allows the game to be easy to start playing, yet still feature profound gameplay. The sequel adds several new puzzle elements, such as gel that can render surfaces bouncy or allow you to accelerate when running on them.
                The game is often praised for its gameplay, its memorable dialogue and writing and its aesthetic. Both games in the series are responsible for inspiring most puzzle games succeeding them, particularly first-person puzzle games. The series, its characters and even its items such as the portal gun and the companion cube have become a cultural icon within gaming communities.',
            'images' => '/assets/images/games/2bac0e87cf45e5b508f227d281c9252a.jpg',
            'release_date' => '2011-04-18',
            'updated' => '2024-12-30',
            'cursing' => '5793',
            'platforms' => 'PlayStation 3, PC, Xbox 360, Linux, macOS, Xbox One',
            'developers' => 'Valve Software',
            'genres' => 'Shooter, Puzzle',
            'publishers' => 'Electronic Arts, Valve',
            'category_id' => 16,
        ]);

        Game::create([
            'name' => 'Portal',
            'description' => 'Every single time you click your mouse while holding a gun, you expect bullets to fly and enemies to fall. But here you will try out the FPS game filled with environmental puzzles and engaging story.
                Silent template for your adventures, Chell, wakes up in a testing facility. She’s a subject of experiments on instant travel device, supervised by snarky and hostile GLaDOS.
                Players will have to complete the tests, room by room, expecting either reward, freedom or more tests. By using the gun, that shoots portals (Portal-Gun™), players will move blocks, travel great distance quickly and learn about your current situation, which is unraveled through environmental storytelling. What you will be told might be different from what you will see.',
            'images' => '/assets/images/games/7fa0b586293c5861ee32490e953a4996.jpg',
            'release_date' => '2007-10-09',
            'updated' => '2024-12-30',
            'cursing' => '4786',
            'platforms' => 'macOS, PC, Android, PlayStation 3, Xbox 360, Linux, Nintendo Switch',
            'developers' => 'Valve Software, NVIDIA Lightspeed Studios',
            'genres' => 'Action, Puzzle',
            'publishers' => 'Valve, Buka Entertainment, NVIDIA, CyberFront',
            'category_id' => 16,
        ]);

        Game::create([
            'name' => 'Limbo',
            'description' => 'This popular 2D puzzle-platformer creates the atmosphere of isolation, where the player alone can guide the nameless protagonist to his destination. Hostile environments and one-hit deaths may seem difficult, but the game implements a fair amount of checkpoints. The monochrome color palette showcases cartoony proportions of every living thing while making lack of details threatening. Limbo shows you exactly what you encounter, but never how it looks.
                Limbo uses the atmosphere and sound design of the horror genre while avoiding tropes of the modern horror games. The overarching theme and unique style compensated for the rather short game with an abrupt ending, making Limbo one of the most impactful games for the genre.
                The simple controls and easy-to-pick-up mechanics help to make a clear distinction, which part of the stage players can interact with, and which part can lead to the quick death. Even though the game is in black and white, this separation is intuitive and natural, so the player would know exactly where to go or what to do.',
            'images' => '/assets/images/games/9424d6bb763dc38d9378b488603c87fa.jpg',
            'release_date' => '2010-07-21',
            'updated' => '2025-01-03',
            'cursing' => '3923',
            'platforms' => 'PC, Android, PS Vita, PlayStation 4, PlayStation 3, Xbox 360, Linux, macOS, iOS, Xbox One, Nintendo Switch',
            'developers' => 'Double Eleven, Playdead, 鱼俞',
            'genres' => 'Action, Adventure, Indie, Puzzle, Platformer',
            'publishers' => 'Microsoft Studios, Playdead, 鱼俞',
            'category_id' => 16,
        ]);

        Game::create([
            'name' => 'Half-Life 2: Episode Two',
            'description' => 'Right after the escape from the collapsed Citadel, Gordon Freeman and his companion Alyx Vance learn that Combine used the destruction to open a portal, in order to bring powerful reinforcement. No major changes have been applied to the gameplay since the previous episode, instead, players will be invited to experiment with the gravity gun and more physics objects to use as impromptu ammunition. Episode Two brings back every staple of the series, including physic puzzles, driving sections, because it was developed simultaneously with the Episode One, but unlike first one Episode two has more puzzles, including the biggest puzzle in the series up to date.',
            'images' => '/assets/images/games/1988a337305e008b41d7f536ce9b73f6.jpg',
            'release_date' => '2007-10-10',
            'updated' => '2025-01-03',
            'cursing' => rand(450, 7500),
            'platforms' => 'Android, Linux, macOS, PC, Xbox 360',
            'developers' => 'Valve Software, NVIDIA Lightspeed Studios',
            'genres' => 'Action, Shooter, Puzzle',
            'publishers' => 'Valve Software, NVIDIA Lightspeed Studios',
            'category_id' => 16,
        ]);

        Game::create([
            'name' => 'Trine 2: Complete Story',
            'description' => 'Trine II takes a few years after the first game. Successfully saving the kingdom, Amadeus seeks the fireball spells. Yet he is summoned to save the homeland with his friends - Zoya and Pontious. Goblins have taken over the land as they are trying to find the mysterious "Witch" deep in the forest.
                Although having more than one playable character, Trine successfully uses all three of them. Amadeus as the mage is able to move objects or create boxes and planks to help overcome some obstacles. Zoya is very agile so she can hook and grapple on some surfaces, or shoot different targets. Pontious is the strongest character in combat, and he can destroy walls in his path or deflect things with his shield. Having this three different characters, it is necessary to use all three of them to solve puzzles and beat the level. Not only you can play alone, but the game supports three players cooperative to make progress even more atmospheric.
                Beautiful design, music and a narrator makes Trine a great story, that feels inspired by J.R.R. Tolkien himself.',
            'images' => '/assets/images/games/c97b943741f5fbc936fe054d9d58851d.jpg',
            'release_date' => '2013-06-05',
            'updated' => '2024-12-27',
            'cursing' => rand(450, 7500),
            'platforms' => 'PlayStation 4, Nintendo Switch, PC, Linux, macOS',
            'developers' => 'Frozenbyte',
            'genres' => 'Action, Indie, Puzzle, Platformer',
            'publishers' => 'Frozenbyte',
            'category_id' => 16,
        ]);

        Game::create([
            'name' => 'INSIDE',
            'description' => 'INSIDE is a platform adventure game that transfers the atmosphere of a dystopic world. Players assume the role of a lonely boy, who walks through the monochromatic 2.5D environment and solves various puzzles. By the time main antagonists of the character pursue him throughout the whole world. The main storyline follows the unnamed boy through the in-game world locations including a forest, a farm, and a fictional laboratory, where experiments on bodies are held. The gameplay is divided into levels tied to each location. While completing them, the boy, controlled by players, has to swim, run, climb the obstacles and use his supernatural ability to control bodies with his special helmet. In the course of the travel, the protagonist also comes across a siren-like creature, who gives him gear for breathing underwater. The death occurs in several ways ranging from drowning to being shot with a tranquilizer dart. In addition to the basic ending, the storyline features an alternate one, which unlocks after collecting all the hidden glowing orbs.',
            'images' => '/assets/images/games/d5a24f9f71315427fa6e966fdd98dfa6.jpg',
            'release_date' => '2016-06-28',
            'updated' => '2025-01-03',
            'cursing' => rand(450, 7500),
            'platforms' => 'Nintendo Switch, PC, iOS, macOS, Xbox One, PlayStation 4',
            'developers' => 'Playdead',
            'genres' => 'Action, Adventure, Indie, Puzzle, Platformer',
            'publishers' => 'Playdead',
            'category_id' => 16,
        ]);

        Game::create([
            'name' => 'Hotline Miami',
            'description' => 'Several chapters of top-down shooter action, Hotline Miami is a violent game, where the player takes control of the unnamed man, that receives orders to clear out stages from bandits and mobsters, using every weapon he can get. Over the course of the game, the player will be able to collect the masks that provide buffs and abilities. Fluid and tight combat includes various melee and ranged weapons, that can be used as intended or just thrown at the enemy. Once Jacket, dubbed so for his distinct letterman jacket by fans, arrives at the mission, players will have to clear out every floor from the enemies, using rooms and doors for cover or ambushes. As the story moves on, Jackets mental health will visibly deteriorate, and he will be shown to suffer from hallucinations, which is in tone with acid 80’s theme.',
            'images' => '/assets/images/games/9fa63622543e5d4f6d99aa9d73b043de.jpg',
            'release_date' => '2012-10-22',
            'updated' => '2025-01-04',
            'cursing' => '2583',
            'platforms' => 'Linux, Nintendo Switch, Xbox One, PlayStation 4, PS Vita, PC',
            'developers' => 'Devolver Digital, Dennaton Games',
            'genres' => 'Action, Shooter, Arcade, Indie',
            'publishers' => 'Devolver Digital',
            'category_id' => 8,
        ]);

        Game::create([
            'name' => 'Minecraft',
            'description' => 'One of the most popular games of the 2010s, Minecraft allows you to rebuild the environment around you. The world of the game is open, infinitely wide, and procedurally generated. It is composed of small 3D cubes that represent specific types of materials or terrain. The gameplay is centered on mining and building various structures of your choice. You can also craft items like tools, weapons, and armor. Theres an option to shift to the first or the third person view.
                Minecraft includes multiple modes that dramatically change the focus of the game. Survival and Adventure modes require the player to gather resources, hunt for food and fight monsters to survive. In the Hardcore mode, there’s even permanent death. Creative mode, by contrast, offers you to freely explore the world and construct whatever you want with unlimited resources. There’s also a multiplayer mode that allows the players to share their worlds and engage in the traditional MMO activities, such as player-vs-player combat.
                Minecrafts crude visual style, reminiscent of Lego cubes, became an iconic part of the popular culture. There are many myths and fan fiction surrounding the game, such as the legend of Herobrine, a rumored character that officially doesn’t exist.',
            'images' => '/assets/images/games/b4e4c73d5aa4ec66bbf75375c4847a2b.jpg',
            'release_date' => '2009-05-10',
            'updated' => '2025-01-04',
            'cursing' => rand(450, 7500),
            'platforms' => 'Android, PS Vita, PlayStation 4, PlayStation 3, Xbox 360, Nintendo 3DS, Nintendo Switch, macOS, PC, iOS, Wii U, Xbox One, Linux',
            'developers' => '4J Studios, Mojang',
            'genres' => 'Action, Simulation, Arcade, Massively Multiplayer, Indie',
            'publishers' => 'Microsoft Studios, Mojang',
            'category_id' => 8,
        ]);

        Game::create([
            'name' => 'GRID 2',
            'description' => 'GRID 2 is a racing game, the sequel to Race Driver: GRID.
                In the centre of the "story" GRID 2 is a racing championship, which we gradually promote around the world. Money is not needed, the main thing is to conquer the audience. The race will be held in such places as Paris, Hong Kong, Chicago, Dubai, etc. All the tracks, drivers, teams, cars and sponsors in the game are real.
                Compared to GRID (the first part of the series), there are more modes. There were races on the so-called "Checkpoint", endurance race and other several options. And the significant thing now that there is no driving on the rails, sudden acceleration of rivals and unpunished wiping of bumpers (also, damage to the machine is not displayed on the screen, it is necessary to focus on its behaviour and the replica of racing engineer).
                The main feature of GRID is time rewinding. The number of rewinds is limited, but with this, you can save yourself from a fatal outcome.',
            'images' => '/assets/images/games/27b02ffaab6b250cc31bf43baca1fc34.jpg',
            'release_date' => '2013-05-27',
            'updated' => '2025-01-03',
            'cursing' => rand(450, 7500),
            'platforms' => '',
            'developers' => '',
            'genres' => '',
            'publishers' => '',
            'category_id' => 8,
        ]);

        Game::create([
            'name' => 'Forza Horizon 4',
            'description' => 'Forza Horizon 4 is the eleventh game in the Forza franchise of racing games and the fourth in the Horizon subseries.
            Premise
                Forza Horizon 4 takes place in a shared open world that is loosely based on the United Kingdom. Up to 72 players can share a server at which they participate in races together. They can also purchase in-game homes, which allow the players to unlock faster cars and driver perks. The drivers are customizable up to their clothing and emotions.
            Weather and seasons
                Forza Horizon 4 has a dynamic change of weather and seasons that change on a weekly basis. The weather conditions are synchronized and shared by all players on the same server. The weather and seasons alter the environment and thus the gameplay. Conditions like snow, mud, and ice can influence not only the driving style but also which areas and routes are accessible during which season. Most notably, the players can drive on the ice when lakes and rivers freeze.
            Cars
                Forza Horizon 4 features more than 450 vehicles that are licensed by over one hundred car manufacturers. Among the few notable manufacturers that were not included because of licensing problems are Toyota and Lexus.
            Modes
                Although the game is oriented towards online multiplayer gameplay, it also has a single player and local multiplayer modes. The game also introduces a level editor mode called Route Creator that allows the players to design and customize new routes.',
            'images' => '/assets/images/games/7863e587bac630de82fca50d799236a9.jpg',
            'release_date' => '2018-10-02',
            'updated' => '2025-01-03',
            'cursing' => rand(450, 7500),
            'platforms' => 'PC, Xbox One, Xbox Series S/X',
            'developers' => 'Playground Games',
            'genres' => 'Racing, Arcade',
            'publishers' => 'Playground Games',
            'category_id' => 8,
        ]);

        Game::create([
            'name' => 'Injustice: Gods Among Us Ultimate Edition',
            'description' => 'Injustice: Gods Among Us Ultimate Edition is an extended version of fighting game Injustice: Gods Among Us based on the imaginary universe of DC Comics. The gameplay is made in a traditional fighting 2.5D manner: battles occur in a 2D perspective but all the characters and objects are 3D. All fights are held in one-on-one form, where each participant has two life scales. Game mechanics are simple: three different types of hits and a special ability are available for each character. Some on-map objects are interactive and can be also used in attack. The main action takes place in a universe, which is parallel to a DC’s one, so occasionally clashes may look unusual. According to the storyline, Superman established dictatorship on Earth, and several Justice League members started resisting him. In the game, players are able to take control of favourite DC heroes and to participate in a war between Superman’s domination and the rebellion led by Batman. The Ultimate Edition offers players 6 new characters, over 30 new skins, and 60 new S.T.A.R. Labs missions.
                Injustice: Gods Among Us is followed by the sequel Injustice 2.',
            'images' => '/assets/images/games/23410661770ae13eac11066980834367.jpg',
            'release_date' => '2013-11-12',
            'updated' => '2024-12-29',
            'cursing' => rand(450, 7500),
            'platforms' => 'PlayStation 4, PS Vita, PC, Xbox 360, PlayStation 3',
            'developers' => 'NetherRealm Studios, High Voltage Software, Armature Studio',
            'genres' => 'Action, Arcade, Fighting',
            'publishers' => 'Warner Bros. Interactive',
            'category_id' => 8,
        ]);

        Game::create([
            'name' => 'Limbo',
            'description' => 'This popular 2D puzzle-platformer creates the atmosphere of isolation, where the player alone can guide the nameless protagonist to his destination. Hostile environments and one-hit deaths may seem difficult, but the game implements a fair amount of checkpoints. The monochrome color palette showcases cartoony proportions of every living thing while making lack of details threatening. Limbo shows you exactly what you encounter, but never how it looks.
                Limbo uses the atmosphere and sound design of the horror genre while avoiding tropes of the modern horror games. The overarching theme and unique style compensated for the rather short game with an abrupt ending, making Limbo one of the most impactful games for the genre.
                The simple controls and easy-to-pick-up mechanics help to make a clear distinction, which part of the stage players can interact with, and which part can lead to the quick death. Even though the game is in black and white, this separation is intuitive and natural, so the player would know exactly where to go or what to do.',
            'images' => '/assets/images/games/9424d6bb763dc38d9378b488603c87fa.jpg',
            'release_date' => '2010-07-21',
            'updated' => '2025-01-03',
            'cursing' => '3923',
            'platforms' => 'PC, Android, PS Vita, PlayStation 4, PlayStation 3, Xbox 360, Linux, macOS, iOS, Xbox One, Nintendo Switch',
            'developers' => 'Double Eleven, Playdead, 鱼俞',
            'genres' => 'Action, Adventure, Indie, Puzzle, Platformer',
            'publishers' => 'Microsoft Studios, Playdead, 鱼俞',
            'category_id' => 11,
        ]);

        Game::create([
            'name' => 'Terraria',
            'description' => 'Terraria is a 2D action adventure sandbox game, where players create a character and gather resources in order to gradually craft stronger weapons and armor. Players create randomly generated maps that contain different locations within it, and by gathering specific resources and triggering special events, players will fight one of the many in-game bosses. Created characters can be played on different maps.
                The game introduces hundreds of unique items that can be found across the entirety of the map, some of which may not even be encountered.
                Terraria have many different Biomes and areas with distinct visuals, containing resources and enemies unique to this biome. After gathering materials, players can craft furniture, and build settlements and houses, since after completing events or finding specific items NPCs will start to arrive, and will require player’s protection. Terraria can be played on three difficulties and has a large modding community.',
            'images' => '/assets/images/games/f466571d536f2e3ea9e815ad17177501 (1).jpg',
            'release_date' => '2011-05-16',
            'updated' => '2025-01-03',
            'cursing' => '2384',
            'platforms' => 'Xbox 360, Wii U, Nintendo 3DS, Xbox One, PlayStation 4, iOS, PC, macOS, Linux, Nintendo Switch, PlayStation 3, PS Vita, Android',
            'developers' => 'Engine Software, Codeglue, Pipeworks Studio, Re-Logic',
            'genres' => 'Action, Indie, Platformer',
            'publishers' => '505 Games, Headup Games, Spike Chunsoft, Re-Logic',
            'category_id' => 11,
        ]);

        Game::create([
            'name' => 'Little Nightmares',
            'description' => 'Heavily inspired by Limbo and Inside, Little Nightmares are telling a story of another lost child. Six is a starving little girl in a yellow raincoat, which is trapped in a mysterious vessel named the Maw. Players are taking control of Six’s movement, in order to help her escape the ship and dangerous inhabitants, that’s been kidnaping and preparing children to be served as a feast for the Guests.
                The control scheme is not including any combat moves, leaving players defenseless against any threat. Six can run, crawl, climb, push or pull, and in rare cases carry an object she can throw to stagger an enemy or solve a puzzle. The game gives players the ability to carry a lighted match at any time, inviting players to explore and search for the collectible statues.
                Little Nightmares have 3 DLC levels, expanding the game beyond the perspective of Six, where the Runaway Kid, a young boy, who is trying to catch up to Six and having his own adventure, going through the Maw in the extra chapters, named “The Depths”, “The Hideaway” and “The Residence.”',
            'images' => '/assets/images/games/8a02f84a5916ede2f923b88d5f8217ba.jpg',
            'release_date' => '2017-04-27',
            'updated' => '2025-01-02',
            'cursing' => '1560',
            'platforms' => 'iOS, PlayStation 4, PC, Xbox One, Nintendo Switch',
            'developers' => 'BANDAI NAMCO Entertainment America, Playdigious, Tarsier Studios',
            'genres' => 'Action, Adventure, Platformer',
            'publishers' => 'Bandai Namco Entertainment, BANDAI NAMCO Entertainment US, Playdigious',
            'category_id' => 11,
        ]);

        Game::create([
            'name' => 'Hollow Knight',
            'description' => 'Hollow Knight is a Metroidvania-type game developed by an indie studio named Team Cherry.
                Most of the games story is told through the in-world items, tablets, and thoughts of other characters. Many plot aspects are told to the player indirectly or through the secret areas that provide a bit of lore in addition to an upgrade. At the beginning of the game, the player visits a town of Dirtmouth. A town built above the ruins of Hallownest. The players descend down into the ruins to find some answers to his questions.
                The game revolves mainly around the exploration of the in-game world, which requires the players to have some platforming skills. The players have to find secrets that are scattered around the level and battle their enemies. There is a certain degree of backtracking in the game as some areas are locked until the player defeats a certain boss or picks up a specific item. Each area changes as the plot advances so it may be surprising to come back in a certain area.
                The Protagonist uses a nail which serves as a replacement for a sword. Players can attack in four directions. The nail is upgradable.',
            'images' => '/assets/images/games/4cfc6b7f1850590a4634b08bfab308ab.jpg',
            'release_date' => '2017-02-03',
            'updated' => '2025-01-03',
            'cursing' => '2549',
            'platforms' => 'PlayStation 4, Linux, macOS, PC, Nintendo Switch, Xbox One',
            'developers' => 'Team Cherry',
            'genres' => 'Indie, Platformer',
            'publishers' => 'Team Cherry',
            'category_id' => 11,
        ]);

    }
}
