FROM php:8.1-apache

# 1. Instalar dependencias del sistema y la extensión mysqli para la base de datos
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    libpng-dev \
    && docker-php-ext-install mysqli \
    && docker-php-ext-enable mysqli

# 2. Instalar Composer para que Cloudinary funcione
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 3. Copiar los archivos de tu proyecto al servidor
COPY . /var/www/html/

# 4. Instalar las librerías de Cloudinary
RUN composer install --no-interaction --optimize-autoloader

# 5. Dar permisos para que el servidor pueda leer todo
RUN chown -R www-data:www-data /var/www/html
