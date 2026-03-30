# Signed Identity Laravel Template

A clean Laravel 13 starter that can be used as the foundation for a personal site or any small-to-medium web app.

This repository is designed to be published as a GitHub template so others can generate their own project from it.

## Features

- Laravel 13 + PHP 8.3 baseline
- Vite + Tailwind CSS 4 frontend pipeline
- Pest testing setup (Unit + Feature suites)
- Laravel Pint for code style
- Sensible local defaults (SQLite, database-backed sessions/queue/cache)
- Single-command setup and local development scripts
- `license:update` Artisan command to pull the latest LICENSE text from SPDX

## Requirements

- PHP `8.3+`
- Composer `2+`
- Node.js `18+` and npm
- SQLite (default) or another supported database

## Quick Start

```bash
composer run setup
composer run dev
```

What this does:

- installs PHP dependencies
- creates `.env` from `.env.example` (if missing)
- generates `APP_KEY`
- runs database migrations
- installs frontend dependencies
- builds frontend assets
- starts app + queue worker + log stream + Vite dev server

By default, the app is available at `http://127.0.0.1:8000`.

## Manual Setup (Alternative)

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm install
npm run dev
```

## Environment Notes

The default `.env.example` is optimized for local development:

- `DB_CONNECTION=sqlite`
- `SESSION_DRIVER=database`
- `QUEUE_CONNECTION=database`
- `CACHE_STORE=database`
- `APP_LICENSE=MIT`

If you switch databases (MySQL/PostgreSQL), update `.env` accordingly and rerun migrations:

```bash
php artisan migrate:fresh
```

## Common Commands

```bash
# Run tests
composer test

# Run tests directly
php artisan test

# Format PHP code
./vendor/bin/pint

# Build production frontend assets
npm run build

# Refresh LICENSE from SPDX using APP_LICENSE in .env (default: MIT)
php artisan license:update

# Refresh LICENSE with a specific SPDX identifier
php artisan license:update Apache-2.0
```

## Project Structure

- `app/` - application code (controllers, models, providers)
- `resources/` - Blade views, CSS, JavaScript
- `routes/web.php` - web routes
- `database/migrations/` - schema migrations
- `tests/` - Pest test suites

## Using This as a Template

If this repository is marked as a GitHub template:

1. Click **Use this template** on GitHub.
2. Create your new repository.
3. Clone your new repository locally.
4. Run `composer run setup`.
5. Start development with `composer run dev`.

## Customization Checklist

After creating your own project from this template:

- Update `APP_NAME` and `APP_URL` in `.env`
- Set `APP_LICENSE` in `.env` to your chosen [SPDX identifier](https://spdx.org/licenses/) (default: `MIT`)
- Run `php artisan license:update` to write the corresponding `LICENSE` file
- Replace branding assets in `public/images/`
- Update the default route/view in `routes/web.php` and `resources/views/`
- Review queue/cache/session drivers for your environment
- Add your own feature tests in `tests/Feature/`

## Deployment Notes

For production, remember to:

- set `APP_ENV=production` and `APP_DEBUG=false`
- configure a real cache/session/queue backend as needed
- run `php artisan config:cache`, `php artisan route:cache`, and `php artisan view:cache`
- run a queue worker process if using queued jobs
- build frontend assets with `npm run build`

## Contributing

Contributions are welcome. Open an issue or submit a pull request with a clear description of the change.

Given this project's security focus, **all commits must be GPG-signed**. To set this up:

```bash
# Configure Git to sign all commits automatically
git config --global user.signingkey <YOUR_GPG_KEY_ID>
git config --global commit.gpgsign true
git config --global tag.gpgsign true
```

Add your public key to your [GitHub account](https://github.com/settings/keys) so that commits show as **Verified**. Unsigned pull requests will not be merged.

## License

This project is open-sourced under the [MIT license](LICENSE).
