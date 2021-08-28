FROM php:8-fpm-alpine

RUN apk add --no-cache libzip-dev icu-dev \
        nginx supervisor curl \
    && docker-php-ext-install pdo_mysql zip intl \
    && mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

COPY docker/dev/nginx/nginx.conf /etc/nginx/nginx.conf

COPY docker/dev/php/php.ini $PHP_INI_DIR/conf.d/custom.ini

COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

WORKDIR /app

EXPOSE 80

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]

COPY --from=composer /usr/bin/composer /usr/local/bin/composer

ENV COMPOSER_ALLOW_SUPERUSER=1