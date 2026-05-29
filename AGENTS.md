# Pixel Miniapps / ShareLoop - project guide for agents

## What this repository is

This is a CakePHP 5 application running on PHP 8.2. The project combines several small mini-apps and the ShareLoop module, which is the main custom area with its own configuration, schema, services, controllers, and database migrations.

## Main areas

- `src/Controller/` contains the application flows for pages, monitoring, Papo, personality, scavenger, and TV app screens.
- `src/Model/` contains entities and table classes for the ShareLoop domain.
- `src/Service/QrCodeService.php` generates ShareLoop QR-related URLs and uses the ShareLoop base URL configuration.
- `config/` contains routes, app settings, and ShareLoop-specific configuration.
- `config/Migrations/` contains the database migrations for the ShareLoop schema.
- `config/schema/shareloop.sql` is the reference SQL schema for ShareLoop.
- `templates/` contains the rendered views for the controllers and features above.

## Important routes

The application routes are defined in `config/routes.php`. Notable entry points include:

- `/` - home page
- `/abc`, `/test`, `/abcgame`, `/abcgame2`
- `/pismenkova-zahrada`
- `/papotv`, `/papotv/item`, `/papotv/image/{fileId}`, `/papotv/video/{fileId}`
- `/scavenge` and stage-specific scavenger routes such as `/scavenge/stage_sudoku`
- `/personality/prod`, `/personality/cm`, `/personality/individual`
- `/tv`, `/tv/{screen_id}`
- `/tv-app/{screen_id}` and admin routes under `/tv-app/{screen_id}/admin`

## ShareLoop domain model

ShareLoop currently revolves around these database tables:

- `shareloop_users`
- `shareloop_user_verifications`
- `shareloop_item_types`
- `shareloop_books`
- `shareloop_user_locations`
- `shareloop_user_books`
- `shareloop_book_borrowings`
- `shareloop_reading_lists`

The schema supports book sharing, borrowing, locations, item types, verification emails, and reading lists.

## Configuration notes

- ShareLoop settings live in `config/shareloop.php`.
- QR code URLs default to `http://localhost:8765/shareloop`.
- Email verification expiry defaults to 7 days.
- ISBN lookup can use Google Books and Open Library.
- Default pagination limit is 20.

## Common commands

Use the Docker-based workflow for database migrations:

```bash
docker compose exec php-fpm bin/cake migrations migrate
```

Other useful commands:

```bash
composer install
bin/cake test
bin/cake cs-check
```

## Working rules for agents

- Prefer minimal, focused changes and keep CakePHP conventions intact.
- Check routes, controllers, tables, entities, and templates together when changing a feature.
- Do not assume ShareLoop is a separate app; it is part of this CakePHP codebase.
- When touching persistence, update migrations and schema references together.
- When changing QR or sharing behavior, inspect `config/shareloop.php` and `src/Service/QrCodeService.php` first.
