FROM php:8.2-fpm

#extensiones para laravel
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libzip-dev \
    zip \
    && docker-php-ext-install pdo pdo_mysql zip

# Instala composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN docker-php-ext-install pdo pdo_mysql

RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

RUN chown -R www-data:www-data /var/www


WORKDIR /var/www/html
