ARG PUBLIC_IMAGE
FROM ${PUBLIC_IMAGE} AS public

FROM nginx:1.17.3

ADD ./docker/config/nginx/api.conf /etc/nginx/conf.d/default.conf

COPY --from=public /var/www/app/public /var/www/app/public
