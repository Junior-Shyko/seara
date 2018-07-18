FROM fcoedno/php:7.1-fpm-dev
WORKDIR /var/www/app
RUN apk update && apk add nodejs
RUN mkdir /.npm && chmod -R 777 /.npm
RUN npm install
