ARG BASE_IMAGE

FROM ${BASE_IMAGE} as base

COPY ./admin/ /var/www/app/

RUN apk --no-cache add shadow && usermod -u 1000 www-data

WORKDIR /var/www/app

RUN mkdir -p /root/.composer

RUN composer install

RUN composer dump-autoload

FROM ${BASE_IMAGE}

RUN apk --no-cache add shadow && usermod -u 1000 www-data

COPY --from=base --chown=www-data /var/www/app /var/www/app

USER www-data

CMD ["php-fpm", "-F"]

WORKDIR /var/www/app

EXPOSE 9000
