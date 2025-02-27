# Usar a imagem oficial do PHP com extensões necessárias para Laravel
FROM php:7.2-fpm

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    nginx \
    supervisor

RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Instalar extensões do PHP
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

COPY composer.json composer.lock ./
RUN chown -R www-data:www-data /var/www

# Definir o diretório de trabalho
WORKDIR /var/www

# Instalar as dependências do Composer
# Copiar arquivos de configuração do Laravel
COPY .env.example .env


# Expor a porta 9000 e iniciar o PHP-FPM
EXPOSE 9000

# Copiar o arquivo de configuração do supervisor

COPY ./ /var/www
# Comando para iniciar o supervisor
# CMD ["/usr/bin/supervisord"]
