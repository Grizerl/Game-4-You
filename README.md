# 🎮 Game 4 You

**Your destination for everything gaming — PC, console and mobile.**
Browse the catalog, filter by category, meet the creators and companies behind the games, read the news and leave comments.

![PHP](https://img.shields.io/badge/PHP-8.4-777BB4?logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-13-FF2D20?logo=laravel&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8-4479A1?logo=mysql&logoColor=white)
![Vite](https://img.shields.io/badge/Vite-6-646CFF?logo=vite&logoColor=white)
![Sass](https://img.shields.io/badge/SCSS-Sass-CC6699?logo=sass&logoColor=white)
![Elasticsearch](https://img.shields.io/badge/Elasticsearch-9-005571?logo=elasticsearch&logoColor=white)

## ✨ Features

- **Games catalog** with category filter, ratings, platforms, screenshots, trailers and a "new" badge
- **Categories, creators and companies** with their own pages
- **News section** — Markdown articles with tags, links to games and studios, scheduled publishing and an RSS feed (`/news/feed`)
- **Global search** (Elasticsearch 9) — suggestions dropdown across games, creators, companies, news and categories; empty submit just highlights the field
- **Comments** on game pages
- **Multilingual UI** — Ukrainian (default) and English, localized URLs (`/uk/...`, `/en/...`), translatable content stored as JSON, and a language switcher (`UA` / `EN`) in the footer and the burger menu
- **Images** — covers, avatars and logos stored with Spatie Media Library and served as WebP thumbnails; sizes are configurable in the admin panel
- **SEO** — canonical, hreflang, Open Graph and JSON-LD on public pages
- **Admin panel** (`/control`, English only, authentication required) — CRUD for games, categories, creators, companies, news and **users**, plus image size settings
- **Public JSON API** under `/api`
- **Telegram notification** when a new game is added

## 🧰 Tech stack

| Layer | Tools |
|---|---|
| Backend | PHP 8.4, Laravel 13, Sanctum, Breeze |
| Localization | `mcamara/laravel-localization`, `spatie/laravel-translatable` |
| Database | MySQL 8 (sessions, cache and queues also use the database) |
| Search | Elasticsearch 9 (`elasticsearch/elasticsearch`) with `analysis-ukrainian` / `analysis-phonetic` plugins |
| Media | `spatie/laravel-medialibrary` (WebP conversions) |
| Frontend | Blade, Vite 6, **SCSS (Sass)**, Tailwind CSS 3 (auth pages), Bootstrap 5, Alpine.js (Node 22) |
| Quality | PHPUnit 13, Laravel Pint |
| Workflow | [OpenSpec](https://github.com/Fission-AI/OpenSpec) spec-driven changes, git flow, Claude Code |

## 🚀 Getting started

### Requirements

- PHP **8.4+** with `pdo_mysql`, `mbstring`, `intl`, `gd`, `zip`, `bcmath`, `fileinfo`
- Composer 2, Node.js 18+ (22 recommended), MySQL 8
- Optional: Elasticsearch 9 for the site search

### Install

```bash
git clone https://github.com/Grizerl/Game-4-You.git
cd Game-4-You/game

composer install
cp .env.example .env
php artisan key:generate
```

Configure the database in `.env`. `.env.example` defaults to SQLite, but the project is developed against MySQL:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=game
DB_USERNAME=your_user
DB_PASSWORD=your_password
```

Optional settings (already listed in `.env.example` unless noted):

```dotenv
SOCIAL_STEAM_URL=https://store.steampowered.com/   # "Play now" link on the home page
SOCIAL_DISCORD_URL=https://discord.com/
SEARCH_ENABLED=false                               # true once Elasticsearch is running
ELASTICSEARCH_HOST=http://elasticsearch-9:9200
SEARCH_INDEX=games4you_content

# not in .env.example — Telegram notifications about new games
TELEGRAM_BOT_TOKEN=
TELEGRAM_CHAT_ID=
```

Then migrate, link the storage and build the assets:

```bash
php artisan migrate
php artisan storage:link
npm install
npm run build        # compiles SCSS into public/build; `npm run dev` while developing
php artisan serve
```

Open <http://localhost:8000> — it redirects to the localized home page.

> `public/build` is git-ignored: run `npm ci && npm run build` on every deployment.

**Demo data (local database only — the seeders truncate tables):**

```bash
php artisan db:seed
php artisan media:import-legacy   # imports legacy image paths into Media Library and builds WebP thumbnails
php artisan search:reindex        # only when search is enabled
```

In production the queue worker (`php artisan queue:work`) and the scheduler (`php artisan schedule:run` every minute) must be running: they index content changes, publish scheduled news and regenerate images.

### 🐳 Running with Laradock

The project is developed inside [Laradock](https://laradock.io) on PHP 8.4 (`php-fpm-84`, `workspace-84`, nginx, MySQL).
The site is served at `http://game4you.local` (add `127.0.0.1 game4you.local` to your `hosts` file).

```bash
cd laradock
docker compose -f docker-compose.yml -f docker-compose.game4you.yml up -d nginx php-fpm-84 mysql

# run artisan / composer inside the PHP 8.4 workspace
docker compose -f docker-compose.yml -f docker-compose.game4you.yml \
  run --rm --no-deps -T -w /var/www/Game-4-You/game workspace-84 php artisan migrate
```

> On Windows with Git Bash prefix the command with `MSYS_NO_PATHCONV=1`, otherwise `/var/www/...` is rewritten into a Windows path.
> Run `npm` locally (Node ≥ 18), not in the workspace — Vite 6 does not start on the Node 16 it ships with.

See [`CLAUDE.md`](CLAUDE.md) for the full list of commands and conventions.

### 🔎 Site search (Elasticsearch 9)

Search in the header dropdown (games, creators, companies, news, categories) is powered by Elasticsearch 9, run as the `elasticsearch-9` service from `docker-compose.game4you.yml`.

```bash
docker compose -f docker-compose.yml -f docker-compose.game4you.yml up -d elasticsearch-9
# inside the workspace: set SEARCH_ENABLED=true and ELASTICSEARCH_HOST in .env, then build the index
php artisan search:reindex
```

Model changes are indexed through the queue (a queue worker and `schedule:run` are required in production). Seeders and raw `DB::table` writes bypass observers — run `search:reindex` after them. With `SEARCH_ENABLED=false` the site works as usual and the search box is hidden.

### 🛠 Admin panel

The admin lives at `/control` (log in first). The interface is always English. Sections: Dashboard, Games, Categories, Creators, Companies, News, Users and Image sizes. Any authenticated user can open it, so create accounts only for people you trust (Users → Add user); you cannot delete your own account.

## 🔌 API

All endpoints are `GET` and return JSON.

| Endpoint | Description |
|---|---|
| `/api/games` | List of games |
| `/api/category` | Games filtered by category |
| `/api/creators` | List of creators |
| `/api/details/{id}` | Details of a single game |
| `/api/user` | Authenticated user (Sanctum) |

## 🗂 Project structure

```
app/
  Console/Commands/   search:reindex, search:sync-scheduled, media:import-legacy
  Http/Controllers/
    Pages/            public pages (home, games, creators, companies, news, search, comments)
    Dashboard/        admin panel (CRUD, users, image settings)
    Api/              JSON API
  Http/Middleware/    SetAdminLocale (forces English in /control)
  Jobs/               search indexing, image regeneration
  Models/             Game, Category, Creator, Company, Article, Tag, Comment, User
  Services/           TelegramService, Search/ (Elasticsearch)
  Support/            ImageSizes, SocialLinks, YouTube, ...
lang/{uk,en}/         translations
resources/
  views/              Blade templates (pages, dashboard, layouts, partials, components)
  scss/               all styles: abstracts/, public/ (site), admin/ (panel), app.scss (Breeze)
routes/               web.php, api.php, auth.php
openspec/             specs/ (current behaviour) and changes/ (active + archive)
tests/Feature/        Admin, Companies, Creators, Games, Home, Images, News, Search, ...
```

## ✅ Testing and code style

```bash
php artisan test      # PHPUnit (uses the `game_test` MySQL database; search is disabled in phpunit.xml)
vendor/bin/pint       # code style
```

> ⚠️ A few legacy tests are still red: `PageControllerTest` (routes that no longer exist), `tests/Feature/Auth/*`, one RSS and one social-links test. Everything under `Admin`, `Companies`, `Creators`, `Games`, `Home`, `Images`, `News` and `Search` is green. Write new tests against the real routes from `routes/web.php`.

## 🧭 Development workflow

Behaviour changes go through [OpenSpec](https://github.com/Fission-AI/OpenSpec) before code:

`/opsx:explore` → `/opsx:propose` → `/opsx:apply` → `/opsx:sync` → `/opsx:archive`

Active changes live in `openspec/changes/`, finished ones in `openspec/changes/archive/`, current specs in `openspec/specs/`.

### 🌿 Git flow

The project uses **git flow**:

| Branch | Purpose |
|---|---|
| `master` | Production-ready code; every release is tagged |
| `develop` | Integration branch; all feature branches start from it |
| `feature/<name>` | A new feature or OpenSpec change (e.g. `feature/news-section`) |
| `release/<version>` | Release preparation (from `develop`, merged into `master` and `develop`) |
| `hotfix/<version>` | Urgent production fix (from `master`, merged into `master` and `develop`) |

```bash
git flow init -d                           # once per clone (needs the git-flow AVH extension)

git flow feature start my-feature          # branches off develop
git flow feature finish my-feature         # merges into develop with --no-ff

git flow release start 1.2.0
git flow release finish 1.2.0              # merges into master and develop, tags 1.2.0

git flow hotfix start 1.2.1                # branches off master
git flow hotfix finish 1.2.1               # merges into master and develop, tags 1.2.1

git push origin master develop --tags
```

No extension? The same flow works with plain git (`git checkout -b feature/x develop`, `git merge --no-ff feature/x`). Install the extension on Windows with `scoop install git-flow-avh` or `choco install gitflow-avh`. Version tags have no `v` prefix (`gitflow.prefix.versiontag` is empty).

## 🏷 Releases

| Version | Highlights |
|---|---|
| `1.0.0` | First release: games catalog, creators and company pages, news section, redesigned home page, SEO meta, Elasticsearch global search |
| `1.1.0` | Media Library with WebP thumbnails and configurable sizes, styles migrated from CSS to SCSS, English-only redesigned admin panel with a Users section |
| `1.1.1` | Fix: tests no longer leave root-owned compiled views that broke the admin (`touch(): Utime failed`) |
| `1.1.2` | Redesigned language switcher (footer + burger menu), sticky header, red outline instead of a hint for an empty search |
| `1.1.3` | README brought up to date |

## 🗺 Roadmap

- Rebuild the front end as a Vue 3 SPA
- Merge games with their authors and optimize the database schema
- Reworked slider
- Custom 404 / 500 error pages
- Game purchases
- Favorites
