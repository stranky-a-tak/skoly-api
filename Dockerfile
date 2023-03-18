FROM php:8.2-fpm as php

RUN apt update \
    && apt install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip \
    && docker-php-ext-install intl opcache pdo pdo_mysql \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip
# RUN docker-php-ext-install pdo pdo_mysql
# RUN pecl install xdebug && docker-php-ext-enable xdebug 

WORKDIR /var/www/api
COPY . .

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN curl -sS https://get.symfony.com/cli/installer | bash

ENTRYPOINT ["Docker/entrypoint.sh", "php-fpm", "-F"]