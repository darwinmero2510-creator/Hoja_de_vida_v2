FROM php:8.1-apache
# Instalamos la extensión necesaria para conectar PHP con MySQL
RUN docker-php-ext-install mysqli
# Copiamos todos tus archivos de VS Code al servidor de Render
COPY . /var/www/html/
# Le decimos a Render que use el puerto 80
EXPOSE 80