ARG PHP_VERSION
FROM php:${PHP_VERSION}-fpm-alpine

COPY php.ini /usr/local/etc/php/php.ini

RUN apk update \
    && apk add $PHPIZE_DEPS \
    && pecl channel-update pecl.php.net \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

COPY xdebug.ini-override /tmp/xdebug.ini-override
RUN cat /tmp/xdebug.ini-override >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# composer
COPY --from=composer /usr/bin/composer /usr/bin/composer
ARG COMPOSER_BIN_DIR
ENV PATH=$PATH:${COMPOSER_BIN_DIR}
RUN apk add unzip
