# 🎮 Game 4 You

**Your destination for everything gaming — PC, console and mobile.**
Browse the catalog, filter by category, meet the creators and companies behind the games, and leave comments.

![PHP](https://img.shields.io/badge/PHP-8.4-777BB4?logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-13-FF2D20?logo=laravel&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8-4479A1?logo=mysql&logoColor=white)
![Vite](https://img.shields.io/badge/Vite-6-646CFF?logo=vite&logoColor=white)
![Tailwind](https://img.shields.io/badge/Tailwind-3-06B6D4?logo=tailwindcss&logoColor=white)

## ✨ Features

- **Games catalog** with category filter, ratings, platforms and a "new" badge
- **Categories, creators and companies** with their own pages
- **Comments** on game pages
- **Multilingual UI** — Ukrainian (default) and English, localized URLs (`/uk/...`, `/en/...`) and translatable content stored as JSON
- **Admin panel** (`/control`) with CRUD for games, categories, creators and companies, protected by authentication and email verification
- **Public JSON API** under `/api`
- **Telegram notification** when a new game is added

## 🧰 Tech stack

| Layer | Tools |
|---|---|
| Backend | PHP 8.4, Laravel 13, Sanctum, Breeze |
| Localization | `mcamara/laravel-localization`, `spatie/laravel-translatable` |
| Database | MySQL 8 (sessions, cache and queues also use the database) |
| Frontend | Blade, Vite 6, Tailwind CSS 3, Bootstrap 5, Alpine.js (Node 22) |
| Quality | PHPUnit 13, Laravel Pint |
| Workflow | [OpenSpec](https://github.com/Fission-AI/OpenSpec) spec-driven changes, Claude Code |

## 🚀 Getting started

### Requirements

- PHP **8.4+** with `pdo_mysql`, `mbstring`, `intl`, `gd`, `zip`, `bcmath`, `fileinfo`
- Composer 2, Node.js 22, MySQL 8

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

Optional — Telegram notifications about new games (not in `.env.example`, add them yourself):

```dotenv
TELEGRAM_BOT_TOKEN=
TELEGRAM_CHAT_ID=
```

Then migrate and build the assets:

```bash
php artisan migrate
npm install
npm run build        # or `npm run dev` while developing
php artisan serve
```

Open <http://localhost:8000> — it redirects to the localized home page.

### 🐳 Running with Laradock

The project is developed inside [Laradock](https://laradock.io) on PHP 8.4 (`php-fpm-84`, `workspace-84`, nginx, MySQL).
The site is served at `http://game4you.local` (add `127.0.0.1 game4you.local` to your `hosts` file).

```bash
cd laradock
docker compose -f docker-compose.yml -f docker-compose.game4you.yml up -d nginx php-fpm-84 mysql

# run artisan / composer / npm inside the PHP 8.4 workspace
docker compose -f docker-compose.yml -f docker-compose.game4you.yml \
  run --rm --no-deps -T -w /var/www/Game-4-You/game workspace-84 php artisan migrate
```

> On Windows with Git Bash prefix the command with `MSYS_NO_PATHCONV=1`, otherwise `/var/www/...` is rewritten into a Windows path.

See [`CLAUDE.md`](CLAUDE.md) for the full list of commands and conventions.

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
  Http/Controllers/
    Pages/            public pages (home, games, creators, companies, comments)
    Dashboard/        admin panel (CRUD)
    Api/              JSON API
  Models/             Game, Category, Creator, Company, Comment, User
  Services/           TelegramService
lang/{uk,en}/         translations
resources/views/      Blade templates (pages, dashboard, layouts, components)
routes/               web.php, api.php, auth.php
openspec/             specs and change proposals
```

## ✅ Testing and code style

```bash
php artisan test      # PHPUnit (uses the `game_test` MySQL database)
vendor/bin/pint       # code style
```

> ⚠️ The existing test suite is outdated: it references routes and factories that no longer exist. New tests should target the routes in `routes/web.php`.

## 🧭 Development workflow

Behaviour changes go through [OpenSpec](https://github.com/Fission-AI/OpenSpec) before code:

`/opsx:explore` → `/opsx:propose` → `/opsx:apply` → `/opsx:sync` → `/opsx:archive`

Active changes live in `openspec/changes/`, current specs in `openspec/specs/`.

## 🗺 Roadmap

- Rebuild the front end as a Vue 3 SPA
- Merge games with their authors and optimize the database schema
- Migrate styles from CSS to SCSS
- Admin panel improvements and a reworked slider
- SEO: JSON-LD structured data
- Custom 404 / 500 error pages
- Game purchases
- Favorites (`openspec/changes/add-game-favorites`)
