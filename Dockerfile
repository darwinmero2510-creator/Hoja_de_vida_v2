FROM php:8.1-apache

RUN apt-get update && apt-get install -y unzip git

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY . /var/www/html/

RUN composer install --no-interaction
