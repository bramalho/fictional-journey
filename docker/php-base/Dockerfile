FROM php:7.4-fpm-alpine

RUN apk update \
    && apk add  --no-cache git mysql-client curl libzip-dev libmcrypt libmcrypt-dev openssh-client icu-dev \
    libxml2-dev freetype-dev libpng-dev libjpeg-turbo-dev g++ make autoconf \
    && docker-php-source extract \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb \
    && docker-php-source delete \
    && docker-php-ext-install pdo_mysql soap intl zip \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && rm -rf /tmp/*

ADD ./docker/config/php/php.ini /usr/local/etc/php/php.ini
