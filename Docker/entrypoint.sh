#!/bin/sh

if [ ! -f "vendor/autoload.php" ]; then
        composer install --no-progress --no-interaction
fi

echo "Waiting for db to be ready"
ATTEMPTS_LEFT_TO_REACH_DATABASE=20
until [ $ATTEMPTS_LEFT_TO_REACH_DATABASE -eq 0 ]; do
        sleep 1
        ATTEMPTS_LEFT_TO_REACH_DATABASE=$((ATTEMPTS_LEFT_TO_REACH_DATABASE - 1))
        echo "Still waiting for db to be ready. $ATTEMPTS_LEFT_TO_REACH_DATABASE attempts left."
done

php bin/console doc:mig:mig --no-interaction
php bin/console doc:fixtures:load --no-interaction

exec $@
