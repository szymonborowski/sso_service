FROM php:8.4-fpm

# Wymagane rozszerzenia
RUN apt-get update && apt-get install -y \
    git zip unzip curl libpng-dev libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Ustaw ścieżkę do aplikacji
WORKDIR /var/www/html

# Kopiujemy kod aplikacji do kontenera (cloud-native)
COPY ./src/ .

# Instalacja zależności
RUN composer install --no-dev --optimize-autoloader

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache