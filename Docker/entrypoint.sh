#!/bin/bash

if [ ! -f "vendor/autoload.php" ]; then
    composer install --no-progress --no-interaction
fi

if [ ! -f ".env" ]; then
    echo "Creating env file"
    cp .env .env
else
    echo : "Env exists"
fi

php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan key:generate
php artisan migrate:fresh --seed

php artisan serve --port=9000 --host=0.0.0.0 --env=.env
exec docker-php-entrypoint "$@"