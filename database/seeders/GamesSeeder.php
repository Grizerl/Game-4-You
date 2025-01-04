<?php

namespace Database\Seeders;

use App\Models\Games;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GamesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     function run(): void
    {
        Games::create([
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
            'publishers' => 'CD PROJEKT RED'
        ]);

        Games::create([
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
            'publishers' => 'Electronic Arts, Valve'
        ]);

        Games::create([
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
            'publishers' => 'Valve'
        ]);

        Games::create([
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
            'publishers' => 'Square Enix'
        ]);

        Games::create([
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
            'publishers' => 'Valve, Buka Entertainment, NVIDIA, CyberFront'
        ]);

        Games::create([
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
            'publishers' => 'Electronic Arts, Valve, Akella'
        ]);

        Games::create([
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
            'publishers' => 'Rockstar Games'
        ]);

        Games::create([
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
            'publishers' => '2K Games, Aspyr'
        ]);

        Games::create([
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
            'publishers' => '2K Games, Aspyr'
        ]);

        Games::create([
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
            'publishers' => 'Square Enix, Feral Interactive'
        ]);

        Games::create([
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
            'publishers' => 'Valve'
        ]);

        Games::create([
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
            'publishers' => '2K Games, Feral Interactive'
        ]);

        Games::create([
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
            'publishers' => 'Activision Blizzard, Bungie'
        ]);

        Games::create([
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
            'publishers' => '505 Games, Starbreeze'
        ]);

        Games::create([
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
            'publishers' => 'Sony Interactive Entertainment, PlayStation PC'
        ]);

        Games::create([
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
            'publishers' => 'Konami'
        ]);

        Games::create([
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
            'publishers' => 'Electronic Arts'
        ]);

        Games::create([
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
            'publishers' => '1C-SoftClub, CD PROJEKT RED, Atari'
        ]);

        Games::create([
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
            'publishers' => 'Feral Interactive, Warner Bros. Interactive'
        ]);

        Games::create([
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
            'publishers' => 'Telltale Games'
        ]);

        Games::create([
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
            'publishers' => 'Valve'
        ]);

        Games::create([
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
            'publishers' => 'Square Enix, Microsoft Studios, Feral Interactive'
        ]);

        Games::create([
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
            'category_id' => '2',
        ]);

        Games::create([
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
            'category_id' => '2',
        ]);

        Games::create([
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
            'category_id' => '2',
        ]);

        Games::create([
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
            'category_id' => '2',
        ]);

        Games::create([
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
            'category_id' => '2',
        ]);

        Games::create([
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
            'category_id' => '2',
        ]);

        Games::create([
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
            'category_id' => '3',
        ]);

        Games::create([
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
            'category_id' => '3',
        ]);

        Games::create([
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
            'category_id' => '3',
        ]);

        Games::create([
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
            'category_id' => '3',
        ]);
        
        Games::create([
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
            'category_id' => '4',
        ]);


        Games::create([
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
            'category_id' => '4',
        ]);


        Games::create([
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
            'category_id' => '5',
        ]);


        Games::create([
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
            'category_id' => '5',
        ]);


        Games::create([
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
            'category_id' => '5',
        ]);


        Games::create([
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
            'category_id' => '5',
        ]);


        Games::create([
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
            'category_id' => '5',
        ]);


        Games::create([
            'name' => 'Brutal Legend', 
            'description' => 'Heavy Metal is a way of life and a world in itself, but Eddie Riggs found the real one, after the accident during a concert left him crushed by the scenery and making the involuntary blood sacrifice to the Ormagöden. The action adventure game with the real-time strategy elements in the open world introduced a star voice cast, compiled by musicians that became prototypes for some of the characters players will encounter during the game. Aside from the main story, players will be able to encounter dozens of side missions that may vary from the defense battles to a race. When using his V-guitar named Clementine, Eddie can cast spells, called Solos, by a simple rhythm game, reminiscent of Guitar Hero. Some story missions are so-called Battles of the Bands, where players will fight the armies in a real-time strategy fashion, and winning by outperforming the enemy band and destroying the stage.', 
            'images' => '/assets/images/games/af7a831001c5c32c46e950cc883b8cb7.jpgz',
            'release_date' => '2009-10-12',
            'updated' => '2024-12-30',
            'cursing' => rand(450, 7500),
            'platforms' => 'Xbox 360, PlayStation 3, Xbox One, iOS, PC, Linux, macOS',
            'developers' => 'Electronic Arts, Double Fine Productions',
            'genres' => 'Action, Strategy',
            'publishers' => 'Electronic Arts, Microsoft Studios, Double Fine Productions',
            'category_id' => '5',
        ]);


        Games::create([
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
            'category_id' => '7',
        ]);

        Games::create([
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
            'category_id' => '7',
        ]);

        Games::create([
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
            'category_id' => '7',
        ]);

        Games::create([
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
            'category_id' => '7',
        ]);

        Games::create([
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
            'category_id' => '7',
        ]);

        Games::create([
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
            'category_id' => '7',
        ]);

        Games::create([
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
            'category_id' => '8',
        ]);

        Games::create([
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
            'category_id' => '8',
        ]);

        Games::create([
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
            'category_id' => '8',
        ]);

        Games::create([
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
            'category_id' => '8',
        ]);

        Games::create([
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
            'category_id' => '8',
        ]);

        Games::create([
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
            'category_id' => '8',
        ]);

        Games::create([
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
            'category_id' => '9',
        ]);
       
        Games::create([
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
            'category_id' => '9',
        ]);

        Games::create([
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
            'category_id' => '9',
        ]);

        Games::create([
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
            'category_id' => '9',
        ]);

        Games::create([
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
            'category_id' => '9',
        ]);

        Games::create([
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
            'category_id' => '9',
        ]);

        Games::create([
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
            'category_id' => '10',
        ]);

        Games::create([
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
            'category_id' => '10',
        ]);

        Games::create([
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
            'category_id' => '10',
        ]);

        Games::create([
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
            'category_id' => '10',
        ]);

        Games::create([
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
            'category_id' => '10',
        ]);

        Games::create([
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
            'category_id' => '11',
        ]);

        Games::create([
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
            'category_id' => '11',
        ]);

        Games::create([
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
            'category_id' => '11',
        ]);

        Games::create([
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
            'category_id' => '11',
        ]);
       
        Games::create([
            'name' => 'Super Meat Boy', 
            'description' => 'Super Meat Boy is a fast-paced 2D platform game that rewards mechanical perfection and accuracy of controls. Meat Boy has to save Bandage Girl from Doctor Fetus, by completing the platforming challenges. The game has 5 main worlds, each consisting of 20 light levels, 20 dark and harder versions of those levels and a boss fight. Meat Boy has only one life and cannot take any damage, but there is no limit on attempts, so players can try and fail the stage until they get it right or collect special bandages. Unique replay system will show the player every try they made at the same time right after they completed the level.
                Super Meat boy has multiple characters, some of them are a different skin for Meat Boy and in-game adaptations of other indie-game protagonists, that can be unlocked by completing their special challenge levels, hidden somewhere in the campaign; or by collecting set amount of bandages. Players will be able to choose any unlocked character for any level from the main menu. The game gives players access to the community created maps, but even without it – Super Meat Boy offers more than 300 levels.', 
            'images' => '/assets/images/games/e04963f3ac4c4fa83a1dc0b9231e50db.jpg',
            'release_date' => '2010-10-20',
            'updated' => '2024-12-30',
            'cursing' => rand(450, 7500),
            'platforms' => 'Linux, Nintendo Switch, Wii U, Xbox 360, PlayStation 4, PS Vita, Android, Web, PC, macOS',
            'developers' => 'NVIDIA Lightspeed Studios, Team Meat',
            'genres' => 'Indie, Platformer',
            'publishers' => 'Microsoft Studios, BlitWorks',
            'category_id' => '11',
        ]);

        Games::create([
            'name' => 'Batman: Arkham Asylum Game of the Year Edition', 
            'description' => 'Batman: Arkham Asylum is the first game in Warner Brothers’ action-adventure franchise Batman: Arkham. The game takes places in fictional Asylum on Arkham Island near Gotham City where dangerous and mentally unstable criminals are kept.
                The story follows Batman as he captures Joker after his assault on Gotham City Hall. The game starts when Batman accompanies convoy that transfers Joker to the Arkham Asylum. With the help from Harley Queen and corrupted police officers, Joker manages to escape. He releases his gang members takes over the Asylum. Now Batman must defeat Joker, restore order in Arkham and save Gotham from bombs that Joker planted in it. During the game, the player meets several characters from Batman universe such as Scarecrow, Killer Croc, Poison Ivy, Commissioner Gordon and others.
                The gameplay is a mix of action sequences, investigations and puzzle solving. In action sequences Batman has to defeat villains with brute force or stealthy, using his numerous gadgets.
                The Game of the Year Edition of Batman: Arkham Asylum includes support of 3D displays, two pairs of 3D glasses, and six previously released DLCs.', 
            'images' => '/assets/images/games/fd882c8267a44621a0de6f9cec77ae90.jpg',
            'release_date' => '2010-03-26',
            'updated' => '2025-01-04',
            'cursing' => rand(450, 7500),
            'platforms' => 'PlayStation 3, PC, PlayStation 4, Xbox 360',
            'developers' => 'Feral Interactive, Rocksteady Studios',
            'genres' => 'Action, Adventure, Platformer',
            'publishers' => 'Square Enix, Warner Bros. Interactive',
            'category_id' => '11',
        ]);

        Games::create([
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
            'category_id' => '12',
        ]);

        Games::create([
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
            'category_id' => '12',
        ]);


        Games::create([
            'name' => 'PlayerUnknown’s Battlegrounds', 
            'description' => 'PLAYERUNKNOWN’S BATTLEGROUNDS is battle-royale shooter made only for the multiplayer experience. Players should do their best to become the last one alive. Matches are held on 3 main maps of a large size (Erangel, Miramar, and Sanhok). Each match has 100 participants fighting for themselves. The battle begins with players making the leap out of the plane to spread out across the map and to gather all possible equipment required for survival. Then, after a while, game intelligence randomly sets a circle shape safe zone, which gamers must reach to stay alive, and marks it on the map. Gear and resources are scattered throughout the map, so players can grab everything they need while running to the zone. Therefore, the main action comes out of the players’ collision on their ways to the circle. You can join the fight either alone or in a team (up to 4 people). Due to the customization system, lots of clothing items and weapon skins could be both bought on the marketplace and found in crates. However, in-app purchases don’t actually affect the gameplay.', 
            'images' => '/assets/images/games/1bd2657b81eb0c99338120ad444b24ff.jpg',
            'release_date' => '2017-12-20',
            'updated' => '2025-01-03',
            'cursing' => rand(450, 7500),
            'platforms' => 'PC, Xbox One, PlayStation 4',
            'developers' => 'Krafton, Bluehole, PUBG',
            'genres' => 'Action, Shooter, Massively Multiplayer',
            'publishers' => 'Krafton, Bluehole, PUBG',
            'category_id' => '12',
        ]);


        Games::create([
            'name' => 'For Honor', 
            'description' => 'The gameplay incorporates elements of the hack-and-slash and fighting game. The player can choose from more than 12 different characters from each of the fractions. The all have their unique moves, weapons, characteristics, abilities, and executions. The fighting system is based on the duel between players. It incorporates the variety of moves such as attacks from different angles, blocks, dodges, stuns, counterattacks, unblockable attacks, and faints.
                Each character has its progression system which allows one to gain new perks, upgrade weapons, armor as well as the increase in rank that affects matchmaking process.
                There are six multiplayer modes: they primarily differ from each other by the number of the players involved in the conflict. The multiplayer modes do not feature any PvE battles — the leftovers are team elimination, flag capture and one on one battles.', 
            'images' => '/assets/images/games/4e0e7b6d6906a131307c94266e5c9a1c.jpg',
            'release_date' => '2017-02-13',
            'updated' => '2025-01-02',
            'cursing' => rand(450, 7500),
            'platforms' => 'Xbox One, PlayStation 4, PC',
            'developers' => 'Ubisoft, Ubisoft Montreal, Ubisoft Toronto, Ubisoft Quebec, Blue Byte',
            'genres' => 'Action, Massively Multiplayer',
            'publishers' => 'Ubisoft Entertainment',
            'category_id' => '12',
        ]);


        Games::create([
            'name' => 'Dota 2', 
            'description' => 'What used to be an unofficial modded map for the Warcraft 3, ended up being the most budgeted cybersport discipline, gathering millions of people to watch annual international championships.
                MOBA genre started with the DOTA, Defense of the Ancients, which can be efficiently described as 5 vs 5 top-down action strategy game, during which players are tasked to destroy the enemy core while protecting their own.
                Players can pick out of the roster of 112 heroes and battle on the single map while taking advantage of field vision, resources and item build that can either make heroes stronger or disable the enemy. DOTA 2 is still active, and receives updates weekly, reshaping metas and refreshing game balance, if by any chance some heroes became unreasonably strong. Each hero has not only a unique set of abilities but is fully customizable, through getting items for heroes after matches of through the trade. Not only heroes but terrain, couriers, that deliver items for you and even match announcers, that can be voiced by heroes, professional casters of just memorable characters from other forms of media.', 
            'images' => '/assets/images/games/6fcf4cd3b17c288821388e6085bb0fc9.jpg',
            'release_date' => '2013-07-09',
            'updated' => '2025-01-04',
            'cursing' => rand(450, 7500),
            'platforms' => 'Linux, macOS, PC',
            'developers' => 'Valve Software',
            'genres' => 'Action, Massively Multiplayer',
            'publishers' => 'Valve',
            'category_id' => '12',
        ]);


        Games::create([
            'name' => 'Path of Exile', 
            'description' => 'Path of Exile is inspired by Diablo II and follows it basically in most of the aspects. Randomly filled pre-set of locations, heavy grind and a possibility of replaying most of the areas leaves us with only one possible outcome.
                Players wake up on grim shores of Wraeclast. Without any knowledge who we are or what have we done, players must start to explore an aggressive and cruel fantasy world of criminals, bandits and murderers. Discover the mystery of a long forgotten the Eternal Empire, and survive.
                Mechanics are pretty simple. Choose one of six different classes, gather gems for more skills to use and grind good and synergising equipment. Due to replaying, you can grind any needed equipment or resources to buy it from vendors. Infinite loop of gameplay will still be challenging. The cooperative mode allows beating the game with a party of friends up to six people at the same time.', 
            'images' => '/assets/images/games/d0f91fe1d92332147e5db74e207cfc7a.jpg',
            'release_date' => '2013-10-23',
            'updated' => '2024-12-29',
            'cursing' => rand(450, 7500),
            'platforms' => 'Xbox One, PlayStation 4, PC',
            'developers' => 'Grinding Gear Games',
            'genres' => 'Action, RPG, Massively Multiplayer, Indie',
            'publishers' => 'Grinding Gear Games',
            'category_id' => '12',
        ]);

        Games::create([
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
            'category_id' => '13',
        ]);

        Games::create([
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
            'category_id' => '13',
        ]);

        Games::create([
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
            'category_id' => '13',
        ]);

        Games::create([
            'name' => 'Burnout Paradise: The Ultimate Box', 
            'description' => 'Burnout Paradise: The Ultimate Box is an extended version of the original Burnout Paradise game. The game offers action racing that sometimes resembles the demolition derby in an open-world setting of Paradise City. The game has a remarkable damage system that improves the whole experience and interrupts monotonous moves across the city, which is free-to-explore for the first time in a series. With The Ultimate Box edition, developers added day/night time cycles and dynamic weather system, so graphics became much better. Changes also affected the gameplay. Now players can race and explore the entire map of the city either by car or by bike that were also added. The racing career begins at the dump, where the driver, controlled by players, gets their first car and two new bikes. Players complete races and fill the “driving license” scale to upgrade the level and to open new cars and events. The free roam mode itself is also an integral part of the gameplay: while traveling across the map drivers are able to perform various stunts and unlock special achievements for the “license” experience.', 
            'images' => '/assets/images/games/7cf38d2d80267c121c6d0d361e9429ce.jpg',
            'release_date' => '2009-02-05',
            'updated' => '2024-12-24',
            'cursing' => rand(450, 7500),
            'platforms' => 'PC',
            'developers' => 'Criterion Games',
            'genres' => 'Racing, Arcade',
            'publishers' => 'Electronic Arts',
            'category_id' => '13',
        ]);


        Games::create([
            'name' => 'DiRT Rally', 
            'description' => 'DiRT Rally for Mac is standing by for Metal
                DiRT Rally is the most authentic and thrilling rally game ever made, road-tested over 80 million miles by the DiRT community. It perfectly captures that white knuckle feeling of racing on the edge as you hurtle along dangerous roads at breakneck speed, knowing that one crash could irreparably harm your stage time.
                DiRT Rally also includes officially licensed World Rallycross content, allowing you to experience the breathless, high-speed thrills of some of the world’s fastest off-road cars as you trade paint with other drivers at some of the series’ best-loved circuits, in both singleplayer and high-intensity multiplayer races.
                • ICONIC RALLY CARS - DiRT Rally boasts over 40 of the most iconic and relevant cars from yesteryear through to modern day, representing the cars that the players want, and the ones that make the most sense for the surfaces they race on.
                • SIX MASSIVE RALLIES WITH OVER 70 STAGES - Head to the muddy paths of Wales, the dusty trails of Greece and the icy tarmac of Monte Carlo. Take on the legendary hillclimb of Pikes Peak, the snowy thrills of Sweden, and the epic scenery of Finland.
                • OFFICIAL FIA WORLD RALLYCROSS CONTENT – Race at the Lydden Hill, Holjes and Hell tracks in six of the fastest off-road cars and take on your friends in high intensity, bumper-to-bumper multiplayer racing.
                • CUSTOM RALLY EVENTS: Take any car on any track – configure and compete in single or multi-stage events.
                • RALLY CHAMPIONSHIPS: Start on the bottom rung of the rally ladder and compete in a succession of events, earning points and money on your way to promotion. Use skilful driving and manage your repair schedules as you work your way to the top division and earn the most lucrative rewards.
                • UPGRADES, REPAIRS, SETUP AND TUNING - DiRT Rally delivers depth in areas beyond driving – elements such as repairs, upgrades, and setup & tuning add a rich and strategic dimension to your rally experience.
                • CHALLENGING, UNCOMPROMISING HANDLING MODEL - Codemasters has completely rebuilt the physical simulation for DIRT Rally to adequately capture how it feels to race across changing surfaces and has created brand new models for differential, suspension, engine mapping and turbo modelling.
                • TEAM MANAGEMENT - Hire and fire your crew members each of whom which will have different skills, improving repair times for different parts of the car. Teach them new skills as they gain experience and work together as a team to improve your performance in events.
                • PLAYER LEAGUE SUPPORT - Get together with friends and run your very own racing league. Join or create unlimited leagues and run them how and when you want.
                • DAILY, WEEKLY AND MONTHLY ONLINE CHALLENGES - It’s you versus the entire DiRT community in a series of one-day, week-long and month-long challenges to earn in-game credits to improve your car and team.', 
            'images' => '/assets/images/games/78dfae12fb8c5b16cd78648553071e0a.jpg',
            'release_date' => '2015-12-07',
            'updated' => '2025-01-03',
            'cursing' => rand(450, 7500),
            'platforms' => 'PlayStation 4, PC, macOS, Xbox One, Linux',
            'developers' => 'Feral Interactive, Codemasters',
            'genres' => 'Simulation, Sports, Racing',
            'publishers' => 'Feral Interactive, Codemasters',
            'category_id' => '13',
        ]);


        Games::create([
            'name' => 'GRID (2008)', 
            'description' => 'GRID is a racing game that lets the player dive into the motorsport, assume the real racer’s role and even control their own racing team. Races and racing championships are held in three main locations – the United States, Europe, and Japan. All racing circuits in the game are the mixture of imaginary and the existing ones. The gameplay is divided into 6 racing classes: GT championships, drifting, touge (climbing the narrow mountain pass like Pikes Peak), open wheel racing, demolition derby, and 24 Hours of Le Mans (additional at the end of the season). Each car of 43 available in the game is tied to one of the event types. Several professional teams compete within these championships. Therefore, to start the career player have to choose one of the disciplines and a professional team to join. While progressing GRID gives an opportunity to create your own racing team, hire sponsors and other drivers, and participate in different events. The gameplay also has a remarkable feature called “flashback” that allows rewinding time to prevent driver’s mistakes.', 
            'images' => '/assets/images/games/fc076b974197660a582abd34ebccc27f.jpg',
            'release_date' => '2008-06-03',
            'updated' => '2024-12-24',
            'cursing' => rand(450, 7500),
            'platforms' => 'Xbox 360, Nintendo DS, PC, PlayStation 3, Xbox One',
            'developers' => 'Codemasters, Firebrand Games',
            'genres' => 'Racing',
            'publishers' => 'Codemasters',
            'category_id' => '13',
        ]);


        Games::create([
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
            'category_id' => '14',
        ]);


        Games::create([
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
            'category_id' => '14',
        ]);


        Games::create([
            'name' => 'DiRT Rally', 
            'description' => 'DiRT Rally for Mac is standing by for Metal
                DiRT Rally is the most authentic and thrilling rally game ever made, road-tested over 80 million miles by the DiRT community. It perfectly captures that white knuckle feeling of racing on the edge as you hurtle along dangerous roads at breakneck speed, knowing that one crash could irreparably harm your stage time.
                DiRT Rally also includes officially licensed World Rallycross content, allowing you to experience the breathless, high-speed thrills of some of the world’s fastest off-road cars as you trade paint with other drivers at some of the series’ best-loved circuits, in both singleplayer and high-intensity multiplayer races.
                • ICONIC RALLY CARS - DiRT Rally boasts over 40 of the most iconic and relevant cars from yesteryear through to modern day, representing the cars that the players want, and the ones that make the most sense for the surfaces they race on.
                • SIX MASSIVE RALLIES WITH OVER 70 STAGES - Head to the muddy paths of Wales, the dusty trails of Greece and the icy tarmac of Monte Carlo. Take on the legendary hillclimb of Pikes Peak, the snowy thrills of Sweden, and the epic scenery of Finland.
                • OFFICIAL FIA WORLD RALLYCROSS CONTENT – Race at the Lydden Hill, Holjes and Hell tracks in six of the fastest off-road cars and take on your friends in high intensity, bumper-to-bumper multiplayer racing.
                • CUSTOM RALLY EVENTS: Take any car on any track – configure and compete in single or multi-stage events.
                • RALLY CHAMPIONSHIPS: Start on the bottom rung of the rally ladder and compete in a succession of events, earning points and money on your way to promotion. Use skilful driving and manage your repair schedules as you work your way to the top division and earn the most lucrative rewards.
                • UPGRADES, REPAIRS, SETUP AND TUNING - DiRT Rally delivers depth in areas beyond driving – elements such as repairs, upgrades, and setup & tuning add a rich and strategic dimension to your rally experience.
                • CHALLENGING, UNCOMPROMISING HANDLING MODEL - Codemasters has completely rebuilt the physical simulation for DIRT Rally to adequately capture how it feels to race across changing surfaces and has created brand new models for differential, suspension, engine mapping and turbo modelling.
                • TEAM MANAGEMENT - Hire and fire your crew members each of whom which will have different skills, improving repair times for different parts of the car. Teach them new skills as they gain experience and work together as a team to improve your performance in events.
                • PLAYER LEAGUE SUPPORT - Get together with friends and run your very own racing league. Join or create unlimited leagues and run them how and when you want.
                • DAILY, WEEKLY AND MONTHLY ONLINE CHALLENGES - It’s you versus the entire DiRT community in a series of one-day, week-long and month-long challenges to earn in-game credits to improve your car and team.', 
            'images' => '/assets/images/games/78dfae12fb8c5b16cd78648553071e0a.jpg',
            'release_date' => '2015-12-07',
            'updated' => '2025-01-03',
            'cursing' => rand(450, 7500),
            'platforms' => 'PlayStation 4, PC, macOS, Xbox One, Linux',
            'developers' => 'Feral Interactive, Codemasters',
            'genres' => 'Simulation, Sports, Racing',
            'publishers' => 'Feral Interactive, Codemasters',
            'category_id' => '14',
        ]);

        Games::create([
            'name' => 'VRChat', 
            'description' => 'VRChat is a massive multiplayer online game which allows you to communicate with other players in virtual reality. In fact, it’s a social simulator focused on user-generated content: you create your own world, explore and develop it, meet guests and start relationships. The environment you create is only limited by your imagination.
                VRChat provides full body customizable avatars and emotes, emoji, and hand gestures for you to express your feelings. The game features multiple activities, such as Bowling, VR Karaoke and Capture a Flag matches. You can also explore the worlds created by other players and organize and participate in various social events, for example, start a dancing class or musical performance. The abilities are unlimited. VRChat works as a social network that allows you not only chat and share content but produce it in the form of realistic 3D models and take part in activities you maybe not have a chance to try in real life.', 
            'images' => '/assets/images/games/11fd681c312c14644ab360888dba3486.jpg',
            'release_date' => '2017-02-01',
            'updated' => '2024-12-31',
            'cursing' => rand(450, 7500),
            'platforms' => 'PC',
            'developers' => 'VRChat',
            'genres' => 'Adventure, Simulation, Sports, Casual, Massively Multiplayer',
            'publishers' => 'VRChat',
            'category_id' => '14',
        ]);


        Games::create([
            'name' => 'TEKKEN 7', 
            'description' => 'Tekken 7 is a fighting game developed by Bandai Namco Entertainment. It is the ninth installment in the series.
            Plot
                An unnamed journalist investigates the Mishima family history after his family got killed in a war that was started by Jin Kazama. In his investigation, the journalist tries to find out why did Jins grandfather kill his own wife and threw his son Kazuya down the cliff. At the same time, Jin goes into hiding after defeating an ancient demon named Azazel while his grandfather takes over Mishima Zaibatsu. The world war goes on.
            Gameplay
                Just like the previous games in the series (apart from Tekken Tag Tournament 1 & 2), Tekken 7s gameplay revolves around one-on-one hand-to-hand fights.
                Players are free to choose one of 43 playable characters. Every character has their own personal list of attacks and combos and drastically differs in play style.
                Several new additions were made to the games combat system. Players can now use devastating hits that will take from 40 to 80 percent of the enemys health if the players health drops too low. Moreover, the players are able to use a Rage Drive. It allows for performing a special hit on a high speed that inflicts major damage to the enemy. The last new addition is Power Crush. This feature lets the players attack their opponent even when theyre under attack. Players cant block their enemies low kicks while using the Power Crush.', 
            'images' => '/assets/images/games/62b035add7205737540d66e082b85930.jpg',
            'release_date' => '2015-03-18',
            'updated' => '2024-12-14',
            'cursing' => rand(450, 7500),
            'platforms' => 'PlayStation 4, PC, Xbox One',
            'developers' => 'BANDAI NAMCO Entertainment America, Bandai Namco Entertainment',
            'genres' => 'Action, Sports, Fighting',
            'publishers' => 'Bandai Namco Entertainment, BANDAI NAMCO Entertainment US',
            'category_id' => '14',
        ]);

        Games::create([
            'name' => 'Jet Set Radio', 
            'description' => 'Jet Set Radio (2000) is an action game that allows players to dive into the atmosphere of teenager gangs of early 2000s Tokyo. The action is set in a 3D fictionalized Tokyo torn by teen gangs clash. Things clarify when Professor K, DJ of the Tokyo-to pirate radio station announces a gang war between Japanese rudies (teenagers, who skate and paint graffiti for self-expression). According to the main idea, teens skate and paint graffiti spots throughout the city and dodge police forces. The story is following a 17-year-old rudie Beat, who, being inspired by Professor K, organizes his own gang to burst into the conflict and to defeat rivals. The gameplay is about skating across the city (using only a few buttons) and tagging all possible graffiti spots. In the course of the game, players will face troubles caused by police riots and especially Capitan Onishima (the main antagonist), whose only aim is to pursue the rebellion of the youth. Jet Set Radio also features cel-shaded visuals in favor of 3D cartoon-like picture.', 
            'images' => '/assets/images/games/fd794a9f0ffe816038d981b3acc3eec9.jpg',
            'release_date' => '2000-06-29',
            'updated' => '2024-12-30',
            'cursing' => rand(450, 7500),
            'platforms' => 'iOS, Xbox 360, Android, Game Boy Advance, Dreamcast, PlayStation 3, PS Vita, PC',
            'developers' => 'SEGA, Blit Software, Smilebit, Blit',
            'genres' => 'Action, Sports, Platformer',
            'publishers' => 'SEGA',
            'category_id' => '14',
        ]);


        Games::create([
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
            'category_id' => '15',
        ]);

        Games::create([
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
            'category_id' => '15',
        ]);


        Games::create([
            'name' => 'SEGA Mega Drive and Genesis Classics', 
            'description' => 'Today it is not so hard to play old games. Emulators are available to anyone with almost any computer. And old memories are filling our minds with those amazing games we played in the past.
                With this collection, you can relive your experiences with those games and play them all over again. The controls are now completely adapt for PC and still look very authentic despite new generation platforms. Some of the titles still support cooperative gameplay through Steam and in the workshop you can find new improvements to the old titles made by players for players. In this bundle, you can find any title you remember from Sega Mega Drive and Genesis - Sonic, Phantasy, Golden Axe, Virtua Fighter and Streets of Rage. Controls are now adapt not only for gamepads but also for the keyboard which means anyone can play it.', 
            'images' => '/assets/images/games/0fd84d36596a83ef2e5a35f63a072218.jpg',
            'release_date' => '2010-06-01',
            'updated' => '2024-12-30',
            'cursing' => rand(450, 7500),
            'platforms' => 'PlayStation 4, macOS, Linux, Xbox One, Nintendo Switch, PC',
            'developers' => 'SEGA, d3t',
            'genres' => 'Action, Adventure, RPG, Fighting, Platformer',
            'publishers' => 'SEGA',
            'category_id' => '15',
        ]);

        Games::create([
            'name' => 'Mortal Kombat X', 
            'description' => 'Mortal Kombat X is a fighting game involving 1x1 encounters. The game is the part of a massive Mortal Kombat franchise which originates in 1992 being one of the first fighting games. The MK universe includes films, literature, and TV-shows, let alone dozens of games.
                The game features unique abilities throughout all of the series titles. Fatality — the final death blow was introduced in the first section and have made its way to the Mortal Kombat X. The new piece of a franchise, nevertheless, implements newer mechanics such as X-Ray — a sharp blow delivered when the respective scale is fulfilled and breaking combos, utilizing the same bar but allowing a player to defend themselves.
                The storyline of a game lists is superb, and every new title brings enrichment into it. Mortal Kombat X tells a story of a self-titled tournament in the NetherRealm — a place somewhere between the land of the living and dead. The victor was supposed to become a NetherRealms curator up until the next round of a championship. The MK X features 24 fighters with expending the list up to 33 playable characters thanks to two DLCs.', 
            'images' => '/assets/images/games/aa36ba4b486a03ddfaef274fb4f5afd4.jpg',
            'release_date' => '2015-04-07',
            'updated' => '2025-01-04',
            'cursing' => rand(450, 7500),
            'platforms' => 'PC, Xbox One, PlayStation 4',
            'developers' => 'Warner Bros. Interactive, NetherRealm Studios, High Voltage Software',
            'genres' => 'Action, Fighting',
            'publishers' => 'Warner Bros. Interactive',
            'category_id' => '15',
        ]);


        Games::create([
            'name' => 'Mortal Kombat 11', 
            'description' => 'Mortal Kombat is back and better than ever in the next evolution of the iconic franchise. The all new Custom Character Variations give you unprecedented control to customize the fighters and make them your own. The new graphics engine showcasing every skull-shattering, eye-popping moment, brings you so close to the fight you can feel it. And featuring a roster of new and returning Klassic Fighters, Mortal Kombats best in class cinematic story mode continues the epic saga over 25 years in the making.', 
            'images' => '/assets/images/games/eb514db62d397c64288160d5bd8fd67a.jpg',
            'release_date' => '2019-04-22',
            'updated' => '2024-12-30',
            'cursing' => rand(450, 7500),
            'platforms' => 'Nintendo Switch, Xbox One, PC, PlayStation 4, Xbox Series S/X, PlayStation 5',
            'developers' => 'NetherRealm Studios, QLOC, Shiver Games',
            'genres' => 'Action, Adventure, Fighting',
            'publishers' => 'NetherRealm Studios, QLOC, Shiver Games',
            'category_id' => '15',
        ]);

        Games::create([
            'name' => 'Broken Age', 
            'description' => 'Broken Age is a classic point-and-click adventure game, which tells a story of two completely different teenagers seeking to change their life pace. The action takes place in an imaginary universe shown in a 2.5D perspective. The gameplay is divided into two main storylines, so players are able to assume the roles of both Vella Tartine and Shay Volta. The game allows switching characters at any time. Firstly, events move players to Sugar Bunting town occupied by fictional monsters called Mogs, which demand a sacrifice of young girls every 14 years. Once the protagonist Vella finds herself chosen to be the sacrificed maiden. As she tries to stay alive, she realizes that the only way out is to fight the monster and to liberate her hometown. The second story tells about Shay, a lone boy imprisoned in a spaceship between two AI systems. The boy seeks independence and starts to explore the entire ship then moving to the whole war-torn galaxy. Both storylines are not expected to connect somehow, but in the course of completion game levels, players start to notice similar slight details.', 
            'images' => '/assets/images/games/3eff92562640e452d3487c04ba6d7fae.jpg',
            'release_date' => '2014-01-28',
            'updated' => '2024-12-11',
            'cursing' => rand(450, 7500),
            'platforms' => 'Android, PS Vita, Nintendo Switch, Linux, macOS, PC, iOS, PlayStation 4, Xbox One',
            'developers' => 'Double Fine Productions',
            'genres' => 'Adventure, Casual, Family, Indie, Puzzle',
            'publishers' => 'THQ Nordic, Double Fine Productions',
            'category_id' => '16',
        ]);

        Games::create([
            'name' => 'Sonic Generations', 
            'description' => 'Sonic Generations is a crossover of modern Sonic with his 1990s incarnation. The blue hedgehog is attacked by a new enemy called Time Eater, who tries to change the past to help Dr. Robotnik. Time Eater kidnaps Sonic’s friends and imprisons them in the various eras of the past. Sonic has to travel back in time to meet the original Sonic and Tails from the 16 bit game series. Old and new versions of characters team up to defeat Time Eater and Robotnik and restore the space-time continuum.
                Sonic will have to revisit the levels from his old games. Each zone is split into “Classic” 2D levels from Sega Genesis and Dreamcast eras, and their “Modern” 3D counterparts from the 2000s. Sonics from the different eras also have their unique abilities, and there’s the Skill Shop, where the characters can obtain new skills. Each zone includes two boss fights and a Doppelganger Race, which is a time trial. When theyre not on the levels, the Sonics reside in the White Zone, an open world that serves as a hub to access the regular zones.
                Sonic Generations includes a lot of unlockable content, such as music, art, special skills and, in some versions, even the original 1991 Sonic the Hedgehog game.', 
            'images' => '/assets/images/games/9a18c226cf379272c698f26d2b79b3da.jpg',
            'release_date' => '2011-11-01',
            'updated' => '2025-01-03',
            'cursing' => rand(450, 7500),
            'platforms' => 'PC, Nintendo 3DS, Xbox 360, PlayStation 3, PlayStation 4, Xbox One',
            'developers' => 'SEGA, Sonic Team, Devil Details',
            'genres' => 'Action, Arcade, Family, Platformer',
            'publishers' => 'SEGA',
            'category_id' => '16',
        ]);

        Games::create([
            'name' => 'Journey', 
            'description' => 'Journey is an indie game placed in a setting of the vast desert. The protagonist is a nameless and speechless figure moving towards the distant mountain. The player gets to know the story without words, but rather through cutscenes. The main character wears a magical scarf, which allows flying for some time, and recharges it with gathered cloth or simply by walking. From time to time the protagonist finds collectible items and discover ruins that can give additional information about the world or the storyline. The only way of interaction with in-game objects is a shout.
                The game transfers the atmosphere of an absolute loneliness. However, during the journey the character can meet other players controlling differently dressed, but generally the same figures. Wandering together can be helpful for both players, as they are able to charge one another’s scarves. The thing is that both players cannot communicate each other in any way, except producing noises. Together players can complete levels and continue moving to their final destination.', 
            'images' => '/assets/images/games/baf9905270314e07e6850cffdb51df41.jpg',
            'release_date' => '2012-03-13',
            'updated' => '2024-12-30',
            'cursing' => rand(450, 7500),
            'platforms' => 'PC, iOS, PlayStation 4, PlayStation 3',
            'developers' => 'thatgamecompany, チョコマメ',
            'genres' => 'Adventure, Family, Indie',
            'publishers' => 'Sony Computer Entertainment, Sony Interactive Entertainment, Annapurna Interactive, チョコマメ',
            'category_id' => '16',
        ]);


        Games::create([
            'name' => 'LEGO The Hobbit', 
            'description' => 'The game follows the plot of the movies rather than the original book. LEGO The Hobbit recreates The Hobbit story using voice samples from the movies, while also parodying it with the addition of the tongue-in-cheek humor. The plot takes place in the high fantasy world of Middle-Earth. Bilbo Baggins, the main protagonist, is a hobbit. He lived a peaceful life until one day a company of thirteen dwarves and the wizard named Gandalf called him to join them on an adventure. Bilbo and his new friends left out on a quest to reconquer the dwarves home, the Lonely Mountain, and its treasures from the wicked dragon Smaug.
                The player controls the Thorins party, switching between characters when needed. Each character has his unique abilities, such as climbing or shooting arrows. The game is divided into a series of short, linear levels that correspond to certain scenes in the movies. On the way, the player has to smash objects made of LEGO and sometimes use them to assemble new objects. The game also has a cooperative multiplayer for two.', 
            'images' => '/assets/images/games/e4fb3fd188f61fabec48dca22e6ef28a.jpg',
            'release_date' => '2014-04-08',
            'updated' => '2024-12-30',
            'cursing' => rand(450, 7500),
            'platforms' => 'PC, PlayStation 3, Nintendo 3DS, Xbox 360, Xbox One, Wii U, PlayStation 4, PS Vita, macOS',
            'developers' => 'Feral Interactive, Warner Bros. Interactive, Travellers Tales',
            'genres' => 'Action, Adventure, Family',
            'publishers' => 'Warner Bros. Interactive',
            'category_id' => '16',
        ]);

        Games::create([
            'name' => 'Hue', 
            'description' => 'In the game, objects can be seen, but with them you can do something only if the color of these objects is different from the color of the games background. For example, you start with a black background, and you can see a black door on a black background - you can see its outline. But you can open it only if you change its color to some other one. or if you change the background color. And you can change the background color only when you find, "open" some color. For example, the first color to open in the game is Aqua. After you open this color, you can make this color the background color of the game. And then the door will be black and you will be able to open it. This technique is used in many games - but usually it is implemented only for one color, for example, white on black or vice versa. In Hue, the player deals with eight colors - after the opening of each next color, the game is correspondingly more complicated.
                There are many objects in the game that you need to interact with in order to go further. And each object has to be made real by using the color mechanics described above. And also find a way to properly interact with the object itself. There are many puzzles in the game, and often they seem to be unresolved, but after the decision is finally found, the player is usually surprised how he could not see this decision from the very beginning.', 
            'images' => '/assets/images/games/2d9f74addd8f5b5f83459c2cb700aaf4.jpg',
            'release_date' => '2016-08-30',
            'updated' => '2025-01-02',
            'cursing' => rand(450, 7500),
            'platforms' => 'PS Vita, PlayStation 4, Nintendo Switch, Xbox One, macOS, PC, Linux, iOS',
            'developers' => 'Curve Digital, Serkan Binici, Fiddlesticks Games, Fiddlesticks',
            'genres' => 'Adventure, Board Games, Indie, Puzzle',
            'publishers' => 'Curve Digital, Serkan Binici',
            'category_id' => '17',
        ]);

        Games::create([
            'name' => 'Armello', 
            'description' => 'Armello is a digital remake of a traditional fantasy tabletop role-playing game in which there are rolling dice and cards, that allows the players to execute certain actions. The gaming area is divided into hexagonal plates, that contain procedurally generated features like caves, buildings, other characters or pieces of equipment. As the game progresses, the players can buy in-game currency to purchase special abilities using the skill tree, that is unique to every character.
                The game uses a turn-based system, where the players can equip new items or acquire new skills while the other players make their turn. The cards and dice are used only when the players directly interact with the in-game world. The players use cards for casting spells, hiring teammates, treating wounds or using the special items that grant temporary abilities.', 
            'images' => '/assets/images/games/3d260e4aaeb88b7ac53c81040ac4b80c.jpg',
            'release_date' => '2015-09-01',
            'updated' => '2024-10-22',
            'cursing' => rand(450, 7500),
            'platforms' => 'Xbox One, iOS, Nintendo Switch, PlayStation 4, PC, Linux, macOS',
            'developers' => 'League of Geeks',
            'genres' => 'Adventure, RPG, Strategy, Board Games, Indie',
            'publishers' => 'League of Geeks',
            'category_id' => '17',
        ]);


        Games::create([
            'name' => 'AdVenture Capitalist', 
            'description' => 'Have you ever found yourself queuing up for your favourite interactive adventure, only to wish for something to fill the empty space while you’re waiting? Well have WE got a deal for you!
                Introducing AdVenture Capitalist - the game you play while playing other, better games!
                AdVenture Capitalist is the world’s greatest capitalism simulator. Start with a humble lemonade stand, and squeeze your way to total fiscal domination! Earn ridiculous sums of cash, diversify your investments, and attract smarmy Angel Investors to give your businesses a boost!
                And the best part is, AdVenture Capitalist can even play itself! Get your businesses booming, then hire a manager to keep making the dough while you’re gone. Money keeps accumulating while you’re offline, just waiting for you to come back and spend spend spend! IT’s so easy, even a socialist could do it!
                The Job Creator was within you all along... now show the rest of the world what youre made of!
                Start your rags to riches adventure - Only in AdVenture Capitalist!', 
            'images' => '/assets/images/games/11b81edff7f45024e36b88e880d86585.jpg',
            'release_date' => '2015-02-19',
            'updated' => '2024-12-30',
            'cursing' => rand(450, 7500),
            'platforms' => 'Linux, PlayStation 4, Android, iOS, PC, macOS',
            'developers' => 'Kongregate, Hyper Hippo Games, Hyper Hippo Productions',
            'genres' => 'Simulation, Board Games, Casual, Indie',
            'publishers' => 'Kongregate, Hyper Hippo Games',
            'category_id' => '17',
        ]);

        Games::create([
            'name' => 'Dota Underlords', 
            'description' => 'Dota Underlords is a new stand-alone game that pits you against seven opponents in a battle of wits that will have you building, combining, and leveling-up a crew in a battle of dominance for the city of White Spire. In this game, victory is determined not by twitch reflexes, but by superior tactics.', 
            'images' => '/assets/images/games/66e90c9d7b9a17335b310ceb294e9365.jpg',
            'release_date' => '2020-02-25',
            'updated' => '2025-01-02',
            'cursing' => rand(450, 7500),
            'platforms' => 'iOS, PC, macOS, Linux, Android',
            'developers' => 'Valve Software',
            'genres' => 'Strategy, Board Games, Casual',
            'publishers' => 'Valve ',
            'category_id' => '17',
        ]);

        Games::create([
            'name' => 'Poker Night 2', 
            'description' => 'Playing poker is good in itself and as an occasion for live communication, a disclosure of communicative talents, a great way to spend time with friends. Especially if these friends know how to play and have fun playing.
                This poker simulator allows you to spend time in a beautiful company. The game lets you play with Sam (Sam & Max franchise), assisted by Max, Brock Samson (The Venture Bros.), Ash Williams (The Evil Dead) and Claptrap (Borderlands). The dealer of the game is GLaDOS (Portal series). Some other popular characters take part as additional characters or cameos.
                All players start the game with the same amount of in-game money, the goal is to win the money of other players. The game can be played in Texas hold em style or in Omaha hold.
                The game is the sequel to Poker Night at the Inventory.', 
            'images' => '/assets/images/games/e40b8c0637de401eb1dec5f5eb05ad33.jpg',
            'release_date' => '2013-04-24',
            'updated' => '2024-12-27',
            'cursing' => rand(450, 7500),
            'platforms' => 'PlayStation 3, Xbox 360, macOS, PC, iOS',
            'developers' => 'Telltale Games',
            'genres' => 'Sports, Board Games, Casual, Card',
            'publishers' => 'Telltale Games',
            'category_id' => '17',
        ]);

        Games::create([
            'name' => 'Papers, Please', 
            'description' => 'The creator of the game often travelled through Asia and made the observation that the work of an immigration officer checking documents for entry is simultaneously very monotonous and very responsible. The game reproduces this work - but scammers and unusual situations occur in it much more often than in reality. The task of the player-officer is not to make a mistake, not to let an unwanted guest into the country. He has power, directories, translucent devices, etc., but experienced masters of deception and fraud act against him. The task of the player is complicated by the fact that his country is like all the paranoid dictatorships at the same time. This country fears a lot, seeks to control everything and periodically generates various rules. The game has a lot of humour, a lot of exciting puzzles and unexpected twists, including shooting. The visual and musical design of the game reflects the bizarre world of stupid rules, constant fear and mutual distrust.', 
            'images' => '/assets/images/games/6d33014a4ed48a19c30a77ead5a0f62e.jpg',
            'release_date' => '2013-08-08',
            'updated' => '2025-01-02',
            'cursing' => rand(450, 7500),
            'platforms' => 'Linux, macOS, PC, iOS, Android, PS Vita',
            'developers' => 'Dukope1, 3909, Lucas Pope',
            'genres' => 'Simulation, Educational, Indie, Puzzle',
            'publishers' => '3909',
            'category_id' => '18',
        ]);

        Games::create([
            'name' => 'Sid Meiers Pirates!', 
            'description' => 'Sid Meier’s Pirates is an action-adventure strategy game, a remake of 1987 game of the same name. It’s set in an open world around the Caribbean islands. The game features numerous activities, including sailing and exploration, ship battles, trading and diplomacy.
                The core gameplay of the game is sailing among the islands, cities and colonies. Every tip on the map provides great opportunities for both economic issues and fights, as you can attack ships and capture cities; some battles include sword fighting mini-game. Completing different quests, you will gain diplomacy points of one of the in-game factions. This will reveal additional options, such as dancing with a governors daughter at a ball. The game also features AI historical pirates, such as Henry Morgan and Blackbeard.
                While the story aspect is not in focus of this game, theres a little background of the hero you play as. After customizing your character, you start as a sailor under the command of a very harsh captain. One day the riot begins, and you become the new captain. Since then you can explore the world and do everything you want together with your crew.', 
            'images' => '/assets/images/games/7ca90d463ea0c0252e7d01afe897ffa8.jpg',
            'release_date' => '2004-11-22',
            'updated' => '2024-12-11',
            'cursing' => rand(450, 7500),
            'platforms' => 'Xbox, Xbox 360, macOS, PC, Xbox One, PSP, Wii',
            'developers' => 'Feral Interactive, 2K, Firaxis, 2K China, Full Fat Productions',
            'genres' => 'Action, Adventure, RPG, Strategy, Simulation, Arcade, Educational, Fighting',
            'publishers' => 'Feral Interactive, 2K, Firaxis',
            'category_id' => '18',
        ]);


        Games::create([
            'name' => 'Sid Meiers Civilization IV: Colonization', 
            'description' => 'Sid Meiers Civilization IV: Colonization is a remake of the famous turn-based strategy game Sid Meiers Colonization which was released in 1994. The game was totally remade with the Civilization IV engine. In the game player controls settlers from four European nations – Spain, England, France and Netherlands. Sid Meiers Civilization IV: Colonization takes place in the period between 1492-1792. The game is mostly about bilding your colonies, army, declare independence from their mother country and defeat enemies who are sent by the king to destroy rebellion. There are four different colonies, four kingdoms and eight different tribes in the game. Player should manage economics, built and expand their cities and manage diplomacy in order to win. Also, there is trade mechanic, which has to be used when player has the required amount of goods which then are sent to Europe or are traded with natives for other goods or gold. Things like silver or ore can be mined in order to make tools which then can be turned into guns.', 
            'images' => '/assets/images/games/31d70d348acf9924a218ddcb80c171be.jpg',
            'release_date' => '2008-09-22',
            'updated' => '2024-10-25',
            'cursing' => rand(450, 7500),
            'platforms' => 'PC, iOS, macOS',
            'developers' => 'Aspyr Media, Firaxis',
            'genres' => 'trategy, Simulation, Educational',
            'publishers' => 'Aspyr Media, Firaxis',
            'category_id' => '18',
        ]);

        Games::create([
            'name' => 'Surgeon Simulator', 
            'description' => 'Surgeon Simulator is a medical simulation game that makes you a surgeon named Nigel Burke. You need to carry out different operations, firstly on people and later on aliens. Famous for its controls, Surgeon Simulator literally gives you the ability to control your virtual left hand’s fingers with A, W, E, R and Space buttons on your keyboard. The mouse is used to move your hand up and down.
                As these controls arent easy to master, its quite hard to carry on the first operations. But the game starts to challenge you from the beginning, offering to operate a patients heart, brains, and other important organs. The games physics model reacts on every mistake you make with blood rivers and a patients death. Because of this Surgeon Simulator became a meme among gamers with videos of its playthroughs gaining thousands of views.', 
            'images' => '/assets/images/games/ca840f2a8ebfc74aac1688367dc1f903.jpg',
            'release_date' => '2013-04-18',
            'updated' => '2025-01-02',
            'cursing' => rand(450, 7500),
            'platforms' => 'PlayStation 4, iOS, PC, macOS, Linux, Nintendo Switch, Android',
            'developers' => 'Bossa Studios',
            'genres' => 'Action, Simulation, Educational, Indie',
            'publishers' => 'Bossa Studios',
            'category_id' => '18',
        ]);

        Games::create([
            'name' => 'GameGuru', 
            'description' => 'Our vision is to produce The Ultimate Easy To Use 3D Game Creator for the PC - A solution that is easier and more affordable than it’s competitors, with a strong community lead development to keep it growing and improving.
                Well embrace new and exciting hardware, acting as champions as we pioneer new experiences and in the process creating fresh new game creating communities. Well keep expanding the gaming possibilities of GameGuru as we move forward.
                Developing game creation tools is what drives us - were super passionate about finding ways to make the whole game creation process as easy as possible.
                The Technical Stuff
                For those who want to understand more – here are the main elements of GameGuru:
                3D Game Engine &amp; Editor
                Easy to use, drag &amp; drop style
                Birds eye view &amp; 3D fly editing systems
                Game world – Construct levels for your games
                Terrain editor – With easy to use controls you can create unique environments
                Infinite vegetation system – Vegetation is auto generated, just paint it on the map
                Rendering engine – powering the shaders to make your games look great
                Level of detail – The game engine supports Level Of Detail technology (LOD)
                Cascade shadow mapping – Real-time dynamic sun shadow
                Lightmapping – Add fast shadows to your levels with the shadow baking system
                Ambient Occlusion Mapping – A feature of the lightmapper
                Sky maps – Choose from a wide range of high-resolution sky maps
                Occlusion Culling System – Fast rendering from a special object culling system
                Water plane – A reflective water plane adds a visual touch to your levels
                Light Rays – Let the light flood your game scenes with cool god rays', 
            'images' => '/assets/images/games/f24122a8e3d30ec3e99472e3e826d0cb.jpg',
            'release_date' => '2015-05-19',
            'updated' => '2024-10-22',
            'cursing' => rand(450, 7500),
            'platforms' => 'PC',
            'developers' => 'The Game Creators',
            'genres' => 'Educational',
            'publishers' => 'The Game Creators',
            'category_id' => '18',
        ]);

        Games::create([
            'name' => 'Poker Night 2', 
            'description' => 'Playing poker is good in itself and as an occasion for live communication, a disclosure of communicative talents, a great way to spend time with friends. Especially if these friends know how to play and have fun playing.
                This poker simulator allows you to spend time in a beautiful company. The game lets you play with Sam (Sam & Max franchise), assisted by Max, Brock Samson (The Venture Bros.), Ash Williams (The Evil Dead) and Claptrap (Borderlands). The dealer of the game is GLaDOS (Portal series). Some other popular characters take part as additional characters or cameos.
                All players start the game with the same amount of in-game money, the goal is to win the money of other players. The game can be played in Texas hold em style or in Omaha hold.
                The game is the sequel to Poker Night at the Inventory.', 
            'images' => '/assets/images/games/e40b8c0637de401eb1dec5f5eb05ad33.jpg',
            'release_date' => '2013-04-24',
            'updated' => '2024-12-27',
            'cursing' => rand(450, 7500),
            'platforms' => 'PlayStation 3, Xbox 360, macOS, PC, iOS',
            'developers' => 'Telltale Games',
            'genres' => 'Sports, Board Games, Casual, Card',
            'publishers' => 'Telltale Games',
            'category_id' => '19',
        ]);


        Games::create([
            'name' => 'Poker Night at the Inventory', 
            'description' => 'Four famous characters - Max (Sam & Max game series), RED Heavy (Team Fortress 2 game), Tycho (Penny Arcade webcomic), and Strong Bad (Homestar Runner web series) - just sit around a table in the underground casino called Inventory and play poker. According to its owner, it is hidden under a video game store and is kept secret so that if the government outlaws gambling one day, it will know nothing of Inventory. The player does not control any of the characters but is instead an invisible character on its own, who is literally referred to as The Player by other characters.
                All players have a reserve of $10,000 at the beginning and leave the game if theyre left nothing to put at stake. The ultimate goal for the player is to remain the last one sitting behind the table. Sometimes the opponents will put their recognizable belongings, such as Heavys iconic bazooka Iron Curtain, at stake. This is essentially a board game, however, funny animation and characters chit-chat filled with references and jokes may keep one interested.
                Achievements in Poker Night at the Inventory allow unblocking certain special features in Team Fortress 2.', 
            'images' => '/assets/images/games/1be2141edae05d4ba9858182b081e604.jpg',
            'release_date' => '2010-11-22',
            'updated' => '2024-08-29',
            'cursing' => rand(450, 7500),
            'platforms' => 'PC, macOS',
            'developers' => 'Telltale Games',
            'genres' => 'Sports, Casual, Card',
            'publishers' => 'Telltale Games',
            'category_id' => '19',
        ]);

        Games::create([
            'name' => 'The Elder Scrolls: Legends', 
            'description' => 'The game centers around turn-based card matches between two opponents. Several game modes are available: Duel and Arena. In Duel, the players start with their own hand of cards, while in Arena each player picks the hand out of a limited number of cards.
                The cards are divided into four categories: Creatures, Supports, Actions, and Items. The players decide which Tamriel race they want to play as. This choice affects the additional cards that will be dropped as a reward after leveling up.
                At the beginning of the match, each player starts out with one magic point and three cards. On each turn, one magic point is granted to the players. The first player to get his enemies health to less than 1 wins.', 
            'images' => '/assets/images/games/4317e294e88e4c9d77327693b15f499a.jpg',
            'release_date' => '2017-03-22',
            'updated' => '2024-10-05',
            'cursing' => rand(450, 7500),
            'platforms' => 'Nintendo Switch, iOS, PC, macOS, Android',
            'developers' => 'Bethesda Softworks, Dire Wolf Digital',
            'genres' => 'Strategy, Card',
            'publishers' => 'Bethesda Softworks, Dire Wolf Digital',
            'category_id' => '19',
        ]);

        Games::create([
            'name' => 'Gwent: The Witcher Card Game', 
            'description' => 'Join in The Witcher universe’s favorite card game! In GWENT, you clash with your friends in fast-paced duels that combine bluffing, on-the-fly decision making and careful deck construction.
                Play your cards right and manage a three-row battle formation as you unleash your hand over a best-of-three series of rounds. With heroes, spells and special abilities that dramatically turn the tide of battle, deception and clever tricks will be necessary parts of your arsenal.
                Pick your side – command five different factions: the mighty Nilfgaardian Empire, proud Skellige, brutal Monsters, cunning Northern Realms, or shadowy Scoia’tael.
                Build your deck – collect new cards and deploy armies full of versatile units, unique heroes and rule-flipping cards that summon fog to blind your opponent’s archers or call down dragon fire to destroy their strongest units.
                Craft new cards – break down unwanted cards and craft new ones to build an ever-evolving deck.', 
            'images' => '/assets/images/games/7424c1f7d0a8da9ae29cd866f985698b (1).jpg',
            'release_date' => '2018-10-23',
            'updated' => '2025-01-03',
            'cursing' => rand(450, 7500),
            'platforms' => 'Xbox One, iOS, PC, PlayStation 4, Android',
            'developers' => 'CD PROJEKT RED, CD PROJEKT',
            'genres' => 'RPG, Strategy, Board Games, Card',
            'publishers' => 'CD PROJEKT RED, CD PROJEKT',
            'category_id' => '19',
        ]);

        Games::create([
            'name' => 'Slay the Spire', 
            'description' => 'We fused card games and roguelikes together to make the best single player deckbuilder we could. Craft a unique deck, encounter bizarre creatures, discover relics of immense power, and Slay the Spire!
            Features:
                Dynamic Deck Building: Choose your cards wisely! Discover hundreds of cards to add to your deck with each attempt at climbing the Spire. Select cards that work together to efficiently dispatch foes and reach the top.
                An Ever-changing Spire: Whenever you embark on a journey up the Spire, the layout differs each time.
                Choose a risky or safe path, face different enemies, choose different cards, discover different relics, and even fight different bosses!
                Powerful Relics to Discover: Powerful items known as relics can be found throughout the Spire. The effects of these relics can greatly enhance your deck through powerful interactions. But beware, obtaining a relic may cost you more than just gold...', 
            'images' => '/assets/images/games/f5206d55f918edf8ee07803101106fa6.jpg',
            'release_date' => '2019-01-22',
            'updated' => '2024-12-30',
            'cursing' => rand(450, 7500),
            'platforms' => 'Xbox One, iOS, PC, macOS, Linux, Nintendo Switch, PlayStation 4, Android',
            'developers' => 'Humble Bundle, Mega Crit',
            'genres' => 'RPG, Strategy, Card, Indie',
            'publishers' => 'Humble Bundle, Mega Crit',
            'category_id' => '19',
        ]);

        Games::create([
            'name' => 'Faeria', 
            'description' => 'The game is played with cards on a special field. The goal of the game is to "kill" the opponent, laying out cards on the field. The game lets you compete with other players or AI.
                The game takes place on an empty hexagonal field, two corners of which are occupied by avatars (against each other), and the other four corners are wells of Faeria (mana). Each player starts the game with thirty cards.
                At the beginning of the turn, the player draws a card from their cards and receives three points of Faeria (mana). If by the player manages to take a well of mana, the player receives one mana point additionally for each well. The game also uses the Power Wheel, different cards have different potentials and affect the game in many ways. Laying out cards on the field also matters - laying out cards is regulated by the rules and gives as a result combinations of different strength and quality. Playing cards spends mana reserves, each card requires a certain amount of mana in reserve to play. And the enemy is harmed through a decrease in the health - the cards affect this figure. Victories give in-game currency to the player, which they can pay for new cards with and make the stock of cards unique.', 
            'images' => '/assets/images/games/f6429c7e6e66c178fde186977ea1af75.jpg',
            'release_date' => '2017-03-08',
            'updated' => '2024-12-15',
            'cursing' => rand(450, 7500),
            'platforms' => 'iOS, Nintendo Switch, PC, macOS, Linux, Xbox One, PlayStation 4',
            'developers' => 'Abrakam, Abrakam Entertainment',
            'genres' => 'Strategy, Card, Massively Multiplayer, Indie',
            'publishers' => 'Versus Evil, Abrakam',
            'category_id' => '19',
        ]);

    }
}
