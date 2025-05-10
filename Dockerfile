FROM php:8.2-fpm

# Instalar extensiones necesarias
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Establecer el directorio de trabajo
WORKDIR /var/www

# Copiar los archivos del proyecto
COPY . .

# Establecer permisos
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage

# Exponer el puerto
EXPOSE 9000

CMD ["php-fpm"]