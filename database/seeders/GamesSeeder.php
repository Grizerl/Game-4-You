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
    public function run(): void
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
            'category_id ' => '2',
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
            'category_id ' => '2',
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
            'category_id ' => '2',
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
            'category_id ' => '2',
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
            'category_id ' => '2',
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
            'category_id ' => '2',
        ]);

        Games::create([
            'name' => '', 
            'description' => '', 
            'images' => '',
            'release_date' => '',
            'updated' => '',
            'cursing' => '',
            'platforms' => '',
            'developers' => '',
            'genres' => '',
            'publishers' => '',
            'category_id ' => '2',
        ]);

        Games::create([
            'name' => '', 
            'description' => '', 
            'images' => '',
            'release_date' => '',
            'updated' => '',
            'cursing' => '',
            'platforms' => '',
            'developers' => '',
            'genres' => '',
            'publishers' => '',
            'category_id ' => '2',
        ]);

        Games::create([
            'name' => '', 
            'description' => '', 
            'images' => '',
            'release_date' => '',
            'updated' => '',
            'cursing' => '',
            'platforms' => '',
            'developers' => '',
            'genres' => '',
            'publishers' => '',
            'category_id ' => '2',
        ]);


    }
}
