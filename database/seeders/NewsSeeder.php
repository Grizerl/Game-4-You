<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Company;
use App\Models\Game;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Демонстраційні новини. Сідер ідемпотентний: статті шукаються за slug, нічого не видаляється.
     */
    public function run(): void
    {
        $covers = collect(glob(public_path('assets/images/games/*')) ?: [])
            ->map(fn (string $path): string => '/assets/images/games/'.basename($path))
            ->values();

        $gameIds = Game::pluck('id');
        $companyIds = Company::pluck('id');

        $tags = [
            'reviews' => Tag::resolve(['uk' => 'Огляди', 'en' => 'Reviews']),
            'announcements' => Tag::resolve(['uk' => 'Анонси', 'en' => 'Announcements']),
            'industry' => Tag::resolve(['uk' => 'Індустрія', 'en' => 'Industry']),
            'guides' => Tag::resolve(['uk' => 'Гайди', 'en' => 'Guides']),
        ];

        foreach ($this->articles() as $index => $data) {
            $article = Article::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'title' => $data['title'],
                    'excerpt' => $data['excerpt'],
                    'body' => $data['body'],
                    'cover_image' => $covers->isNotEmpty() ? $covers[$index % $covers->count()] : null,
                    'published_at' => $data['published_at'],
                ]
            );

            $article->tags()->syncWithoutDetaching(collect($data['tags'])->map(fn (string $key): int => $tags[$key]->id)->all());

            if ($gameIds->isNotEmpty() && $article->games()->doesntExist()) {
                $article->games()->attach($gameIds->shuffle()->take(3)->all());
            }

            if ($companyIds->isNotEmpty() && $article->companies()->doesntExist()) {
                $article->companies()->attach($companyIds->shuffle()->take(2)->all());
            }
        }
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function articles(): array
    {
        $body = fn (string $uk, string $en): array => ['uk' => $uk, 'en' => $en];

        return [
            [
                'slug' => 'how-we-pick-the-best-games',
                'title' => ['uk' => 'Як ми обираємо найкращі ігри місяця', 'en' => 'How we pick the best games of the month'],
                'excerpt' => ['uk' => 'Розповідаємо про критерії добору, рейтинги та те, чому оцінка гравців не завжди збігається з думкою критиків.', 'en' => 'The selection criteria, the ratings and why player scores do not always match the critics.'],
                'body' => $body(
                    "## Критерії добору\n\nМи оцінюємо **геймплей**, *візуальний стиль* і підтримку після релізу. Кожну гру перевіряє щонайменше двоє редакторів.\n\n- Оригінальність ідеї\n- Технічна якість\n- Відгуки спільноти\n\n> Рейтинг — це лише відправна точка, а не вирок.\n\n## Що далі\n\nУ наступних матеріалах покажемо, як ми порівнюємо ігри між собою. Дивіться також [каталог ігор](/games).",
                    "## Selection criteria\n\nWe judge **gameplay**, *visual style* and post-launch support. Every game is checked by at least two editors.\n\n- Originality of the idea\n- Technical quality\n- Community feedback\n\n> A rating is only a starting point, not a verdict.\n\n## What is next\n\nIn upcoming articles we will show how we compare games. See also the [game catalog](/games)."
                ),
                'published_at' => now()->subDays(1)->setTime(10, 0),
                'tags' => ['reviews', 'guides'],
            ],
            [
                'slug' => 'indie-studios-on-the-rise',
                'title' => ['uk' => 'Інді-студії на підйомі: хто задає тренди', 'en' => 'Indie studios on the rise: who sets the trends'],
                'excerpt' => ['uk' => 'Невеликі команди випускають ігри, які конкурують із великими релізами. Розбираємо, у чому їхня сила.', 'en' => 'Small teams ship games that compete with the big releases. We look at what makes them strong.'],
                'body' => $body(
                    "## Невеликі команди, великі ідеї\n\nІнді-студії все частіше **ризикують** там, де великі видавці бояться. Результат — свіжі механіки й унікальні світи.\n\n1. Швидкі прототипи\n2. Близькість до гравців\n3. Експерименти зі стилем\n\nПочитайте також про студії у нашому [розділі студій](/company).",
                    "## Small teams, big ideas\n\nIndie studios increasingly **take risks** where big publishers are afraid to. The result is fresh mechanics and unique worlds.\n\n1. Fast prototypes\n2. Closeness to players\n3. Experiments with style\n\nRead more about studios in our [studios section](/company)."
                ),
                'published_at' => now()->subDays(3)->setTime(14, 30),
                'tags' => ['industry'],
            ],
            [
                'slug' => 'upcoming-releases-announced',
                'title' => ['uk' => 'Анонсовано нові релізи: на що чекати', 'en' => 'New releases announced: what to look forward to'],
                'excerpt' => ['uk' => 'Короткий огляд найочікуваніших анонсів та їхніх платформ.', 'en' => 'A short overview of the most anticipated announcements and their platforms.'],
                'body' => $body(
                    "## Анонси тижня\n\nРедакція зібрала головні новини про майбутні релізи.\n\n| Гра | Платформа |\n| --- | --- |\n| Перша | PC |\n| Друга | PS5 |\n\nСтежте за оновленнями — ми додаватимемо нові матеріали щодня.",
                    "## Announcements of the week\n\nThe editors gathered the main news about upcoming releases.\n\n| Game | Platform |\n| --- | --- |\n| First | PC |\n| Second | PS5 |\n\nStay tuned: we add new articles every day."
                ),
                'published_at' => now()->subDays(6)->setTime(9, 15),
                'tags' => ['announcements'],
            ],
            [
                'slug' => 'beginner-guide-to-co-op',
                'title' => ['uk' => 'Гайд для початківців: як знайти команду для кооперативу', 'en' => 'Beginner guide: how to find a team for co-op'],
                'excerpt' => ['uk' => 'Практичні поради, як швидко зібрати склад і не розчаруватися в спільній грі.', 'en' => 'Practical tips on assembling a squad quickly and not getting disappointed in co-op.'],
                'body' => $body(
                    "## Із чого почати\n\nВизначте **мету**: хочете проходити сюжет чи брати участь у змаганнях.\n\n- Вкажіть свій час гри\n- Домовтеся про голосовий чат\n- Не бійтеся новачків\n\n```\nпорада: дружній тон вирішує більше, ніж рівень\n```",
                    "## Where to start\n\nDecide on your **goal**: finishing the story or taking part in competitions.\n\n- State your play time\n- Agree on voice chat\n- Do not be afraid of beginners\n\n```\ntip: a friendly tone matters more than skill\n```"
                ),
                'published_at' => now()->subDays(9)->setTime(18, 0),
                'tags' => ['guides'],
            ],
            [
                'slug' => 'review-roundup-of-the-year',
                'title' => ['uk' => 'Огляди року: підсумки та несподіванки', 'en' => 'Reviews of the year: results and surprises'],
                'excerpt' => ['uk' => 'Найцікавіші відкриття року й ігри, які варто пройти, навіть якщо ви пропустили їх за кілька місяців.', 'en' => 'The most interesting discoveries of the year and games worth playing even if you missed them months ago.'],
                'body' => $body(
                    "## Підсумки\n\nЦей рік подарував **безліч** цікавих релізів. Ми зібрали найяскравіші.\n\n> Найкраща гра — та, до якої хочеться повертатися.\n\n- Найкращий сюжет\n- Найкраща графіка\n- Найкраща музика",
                    "## Results\n\nThis year gave us **plenty** of interesting releases. We collected the brightest ones.\n\n> The best game is the one you want to come back to.\n\n- Best story\n- Best graphics\n- Best music"
                ),
                'published_at' => now()->subDays(14)->setTime(12, 0),
                'tags' => ['reviews', 'industry'],
            ],
            [
                'slug' => 'behind-the-scenes-of-game-audio',
                'title' => ['uk' => 'За лаштунками ігрового звуку', 'en' => 'Behind the scenes of game audio'],
                'excerpt' => ['uk' => 'Як композитори та звукорежисери створюють атмосферу, яку ми запам\'ятовуємо на роки.', 'en' => 'How composers and sound designers create atmosphere we remember for years.'],
                'body' => $body(
                    "## Звук як персонаж\n\nМузика й ефекти формують **емоції** гравця не менше, ніж картинка.\n\nДетальніше про творців — у [розділі творців](/creators).",
                    "## Sound as a character\n\nMusic and effects shape the player's **emotions** as much as visuals do.\n\nMore about creators in the [creators section](/creators)."
                ),
                'published_at' => now()->subDays(20)->setTime(16, 45),
                'tags' => ['industry'],
            ],
            [
                'slug' => 'draft-upcoming-interview',
                'title' => ['uk' => 'Чернетка: інтерв\'ю з розробниками', 'en' => 'Draft: interview with developers'],
                'excerpt' => ['uk' => 'Матеріал ще редагується.', 'en' => 'The article is still being edited.'],
                'body' => $body('Чернетка тексту.', 'Draft text.'),
                'published_at' => null,
                'tags' => ['announcements'],
            ],
        ];
    }
}
