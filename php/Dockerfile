FROM php:8.1-fpm

COPY php.ini /usr/local/etc/php/

RUN apt update
RUN apt install -y wget git unzip libpq-dev

# Install Node.js 12
RUN apt install -y npm \
    && npm install n -g \
    && n 12

# Install PHP Extensions
RUN apt install -y zlib1g-dev mariadb-client libzip-dev libonig-dev \
    && docker-php-ext-install zip pdo_mysql

COPY --from=composer/composer /usr/bin/composer /usr/bin/composer

# Install Composer
RUN composer self-update

WORKDIR /var/www

RUN chown -R www-data:www-data /var/www

RUN composer global require "phpunit/phpunit"