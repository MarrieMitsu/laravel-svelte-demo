# Laravel-Svelte Demo

Simple Contact CRUD web-app and [REST-API](./REST-API.md). This demo show how I structured Laravel project using InertiaJs(Svelte) and Laravel Action. 

I have strict rules of using and implementing `Action` or maybe a bit radical:

- `Action` API only used for internal implementation and never exposed to the public e.g., `AsController` trait
- `Action` API must have an argument length of at most three, more than that you can utilize `array`, `Collection` or custom `class`
- `Action` API should never throw errors and handled internally, instead we return error as a part of the return value
- `Action` API should return a fixed array that contain various values, usually `error` at index `0` and `result` at index `1`, the order is not matter and you may add another value for specific use cases, mostly these two are more than enough. It's like returning a tuple in other languages or multiple values in Go

This demo using unofficial [@westacks/inertia-svelte](https://github.com/westacks/inertia-svelte) adapter, because the official one has a lot of issues

### What is included?

- [Laravel Sanctum](https://laravel.com/docs/10.x/sanctum)
- [Laravel Actions](https://laravelactions.com/)
- [Daisy UI (TailwindCSS)](https://daisyui.com/)
- [Lucide Icons](https://lucide.dev/icons/)

## Requirements

- `php >= 8.1 < 8.2`
- `Composer`
- `nodejs >= 16`
- `Web Server` (Optional)
- `Docker` (Optional) 

## Installation

First, make sure you have `php` binaries, `composer` program and `nodejs` installed

```bash
# clone project
git clone git@github.com:MarrieMitsu/laravel-svelte-demo.git
# or
git clone https://github.com/MarrieMitsu/laravel-svelte-demo.git

# install php dependencies
composer install

# install nodejs dependencies
npm install

# create new `.env` file by copying the `.env.example` file
cp .env.example .env

# set application key
php artisan key:generate
```

## Configuration

You can edit directly the `.env` file to match your environment.

## Development

### Manual Setup

If you only use it on development mode or testing purpose, you can use PHP built-in web server or using `serve` artisan command from laravel

```bash
# start vite server
npm run dev

# start inertia ssr server (optional for development)
php artisan inertia:start-ssr

# serve application
php -S localhost:8000
# or
php artisan serve
```

#### Migration

```bash
php artisan migrate
```

#### Additional Database Seeding Option

```bash
# seed contact
php artisan db:seed --class=ContactSeeder
```

### Using Docker / Laravel Sail

Refer to laravel documentation [Docker Setup](https://laravel.com/docs/10.x/installation#docker-installation-using-sail)

Make sure you have Docker program in your machine. Additionally, if you are using windows you need to install `WSL2` (Windows Subsystem for Linux)

```
# start new shell instances (optional)
bash

# run sail up command
./vendor/bin/sail up
```

## Testing

First you need to create a database for testing. The database name must match with `phpunit.xml` configuration.

To create a test refer to laravel documentation [Testing](https://laravel.com/docs/10.x/testing) and [PHPUnit](https://phpunit.de/) documentation.

To run all test

```shell
php artisan test
```
