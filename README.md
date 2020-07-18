run `composer install`

Since I used JWT for authentication run the following command below

run `php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"`


then generate a secret key using the command below

`php artisan jwt:secret`

Define your database setup on `.env`


Run the the command below to run the migrations

`php artisan migrate`

<hr/>

Then you're all setup.


Run `php artisan serve` to start you server locally.


API endpoint will be `localhost:{your port}/api/{defined route on the routes/api}`


Download `POSTMAN` to test your routes.


HAPPY CODING !
