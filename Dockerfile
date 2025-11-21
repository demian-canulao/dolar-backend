FROM php:8.2-fpm

# extensiones necesarias
RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /app

COPY . .

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get update && apt-get install -y \
    zip unzip git \
    libzip-dev \
    && docker-php-ext-install zip pdo_mysql
# Instalar composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instalar dependencias de PHP
RUN composer install --no-dev --optimize-autoloader

CMD php artisan serve --host=0.0.0.0 --port=$PORT
