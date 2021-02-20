FROM node:6 as front_builder
WORKDIR /code
RUN npm install -g bower gulp@3.X
RUN apt-get update && apt-get install -y git
COPY resources/assets ./resources/assets
COPY package.json package-lock.json bower.json .bowerrc ./
RUN npm install gulp@3.x laravel-elixir \
    && bower install --allow-root
COPY gulpfile.js ./
RUN gulp

FROM php:7.2.23-cli-alpine as back_builder
WORKDIR /code
RUN apk update --no-cache && apk add --no-cache git
RUN curl https://getcomposer.org/composer-1.phar -o composer.phar -LR -z composer.phar \
    && chmod +x composer.phar \
    && mv composer.phar /usr/local/bin/composer
# Instal dependencies
COPY composer.json composer.lock ./
ENV APP_ENV=production
RUN mkdir database && composer install --prefer-dist --optimize-autoloader --no-dev --ignore-platform-reqs
# Copies the application and execute laravel-specific bootstrapping
COPY bootstrap ./bootstrap
COPY config ./config
COPY database ./database
COPY public/index.php ./public/index.php
COPY public/robots.txt ./public/robots.txt
COPY resources/lang ./resources/lang
COPY resources/views ./resources/views
COPY routes ./routes
COPY app ./app
COPY artisan ./
RUN composer dump-autoload -o && composer run-script setup

FROM alpine:3.4
COPY --from=back_builder /code /code
COPY --from=front_builder /code/public/js /code/public/js
COPY --from=front_builder /code/public/css /code/public/css
COPY --from=front_builder /code/public/fonts /code/public/fonts
COPY --from=front_builder /code/public/img /code/public/img
