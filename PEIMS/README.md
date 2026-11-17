# PEIMS — Pickleball Equipment Inventory Management System

PEIMS is a Laravel application for authenticated administrators to manage pickleball equipment inventory and generate filtered PDF and Excel reports. It does not handle rentals, sales, court reservations, or player transactions.

## Requirements

- PHP 8.3 or newer with the extensions required by Laravel, Dompdf, and OpenSpout
- Composer
- Node.js and npm
- SQLite (the default) or another Laravel-supported database

## Setup

From the project directory:

```bash
composer install
Copy-Item .env.example .env
php artisan key:generate
php -r "file_exists('database/database.sqlite') || touch('database/database.sqlite');"
npm install
npm run build
php artisan migrate --seed
php artisan serve
```

In PowerShell, if `Copy-Item` reports that `.env` already exists, keep the existing file and update its settings rather than replacing it.

SQLite is configured by default. To use MySQL instead, set `DB_CONNECTION=mysql`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` in `.env`, then run the migrations.

The seeded local administrator is:

- URL: `http://127.0.0.1:8000`
- Username: `admin`
- Email: `admin@peims.test`
- Password: `ChangeMeNow!2026`

Change the administrator values in `.env` before running `php artisan db:seed` if you need different credentials. Change the default password before using the application outside a local/demo environment. Public registration is disabled; administrator accounts are seeded or created through trusted administrative processes.

## Features

- Email or username login with rate limiting and secure logout.
- Authenticated equipment CRUD with server-side validation and ownership scoping.
- Equipment categories: paddles, balls, nets, and accessories.
- Availability and category report filters; reset filters without changing saved records.
- PDF and `.xlsx` exports use the same validated filters as the report screen.
- Eight seed equipment records cover every category and both availability states.

## Screenshots

These screenshots are stored at the repository root beside the `PEIMS` project folder:

- [Login](../PEIMS-login.png)
- [Equipment list](../PEIMS-equipment-list.png)
- [Add equipment](../PEIMS-equipment-create.png)
- [View equipment](../PEIMS-equipment-view.png)
- [Edit equipment](../PEIMS-equipment-edit.png)
- [Filtered report](../PEIMS-filtered-report.png)
- [Report export controls](../PEIMS-report-exports.png)

PDF and Excel downloads are generated from saved records and match the active report filters.
