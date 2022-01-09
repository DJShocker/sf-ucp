FROM php:5.6-fpm

# Install PHP extensions
RUN apt-get update && apt-get install -y git libmcrypt-dev zip unzip \
    mysql-client libmagickwand-dev --no-install-recommends \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && docker-php-ext-install mcrypt pdo_mysql pcntl gd

RUN docker-php-ext-install php-mysql

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer