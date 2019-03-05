# This is a blog that is a single page real-time app.

## We are going to use Pusher, Laravel, Vuejs, Vuetify, JWT, and markdown.

## Installation

-   `https://github.com/risticdejan/rt_spa_forum.git`
-   `cd rt_spa_forum`
-   Create a database and inform _.env_ (create this file as .env.example)
-   `composer install`
-   `php artisan key:generate`
-   `php artisan migrate --seed` to create and populate tables
-   `php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"`
-   `php artisan jwt:secret`
-   `npm install` to download npm packages
-   `npm run prod`

## License

MIT
