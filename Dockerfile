FROM php:8.2 as php

RUN apt update && apt install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip \
    && docker-php-ext-install pdo pdo_mysql \
    && pecl install xdebug && docker-php-ext-enable xdebug \
    && pecl install redis && docker-php-ext-enable redis \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip

WORKDIR /var/www
COPY . .

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ENTRYPOINT ["sh", "Docker/entrypoint.sh"]
