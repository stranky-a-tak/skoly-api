FROM php:8.2 as php

RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /var/www
COPY . .

COPY --from=composer:2.3.5 /usr/bin/composer /usr/bin/composer

ENTRYPOINT [ "docker/entrypoint.sh" ]