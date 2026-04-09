# Usamos una imagen oficial de PHP con Apache
FROM php:8.2-apache

# Instalamos las extensiones de MySQL para PHP
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Habilitamos el mod_rewrite de Apache (muy útil para URLs amigables)
RUN a2enmod rewrite

# Damos permisos al directorio web
RUN chown -R www-data:www-data /var/www/html