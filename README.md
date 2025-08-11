# Morph Digital Technical Test

Made with Laravel's Vue starter kit. Refer to [the documentation on starter kits](https://laravel.com/docs/master/starter-kits) for more info.

## To Run

Make sure you have [all the necessary tooling installed](https://laravel.com/docs/master/installation#installing-php)

1. Copy `.env.example` to `.env`
    > Add DB_* values accordingly
1. Run `php artisan migrate && php artisan db:seed` in a terminal
    > The base seeder (`DatabaseSeeder.php`) will set all users' passwords to simply be "password".
    > To log in, simply use one of the generated emails (or "`admin@example.com`" for the one admin user) and "password".
1. Run `pnpm install`
1. Run `php artisan serve`
1. Run `pnpm dev` in a separate terminal instance

## To Test

- `php artisan test`

## Todos

- Build composables out of API calls
