FROM php:7.4-fpm

# Definir o diretório de trabalho
WORKDIR /var/www/html

# Instalar dependências
RUN apt-get update && \
    apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    libxml2-dev \
    && docker-php-ext-configure zip \
    && docker-php-ext-install pdo_mysql gd xml zip

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copiar código da aplicação
COPY . .

# Instalar dependências do Laravel
RUN composer install --optimize-autoloader --no-dev

# Definir permissões para storage e cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expor a porta 9000 do PHP-FPM
EXPOSE 9000

# Comando para iniciar o PHP-FPM
CMD ["php-fpm"]
