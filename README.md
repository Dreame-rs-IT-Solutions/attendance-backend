# Work Immersion Attendance

### Tech Stack

* Laravel 6.x

## Installation

Work Immersion Attendance requires Composer to run LOCALLY.

- [composer](https://getcomposer.org/download/)
- [xampp](https://www.apachefriends.org/download.html)

After downloading composer, clone repository into your computer/server or download the zip file of the repository

```sh
$ git clone <repository-link>
```

Install project dependencies
```sh
$ composer install
```

Create .env for laravel and generate key

```sh
$ cp .env.example .env
$ php artisan key:generate
```

Migrate database with seeders

```sh
$ php artisan migrate:fresh --seed && php artisan passport:install --force
```

Run Server
```sh
$ php artisan serve
```

### Testing

Run command for laravel testing
```sh
$ ./vendor/bin/phpunit
```
