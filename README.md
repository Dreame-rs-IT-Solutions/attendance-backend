# Work Immersion Attendance

### Tech

* Laravel 6.x

### Installation

PITSTOP requires Composer to run.

Install project dependecies
```sh
$ composer install && npm install
```

Create .env for laravel and generate key

```sh
$ cp .env.example .env
$ php artisan key:generate
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
