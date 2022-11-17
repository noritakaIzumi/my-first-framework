ARG PHP_VERSION
FROM php:${PHP_VERSION}-fpm-alpine

COPY php.ini /usr/local/etc/php/php.ini

RUN apk update \
    && apk add $PHPIZE_DEPS libpq-dev \
    && pecl channel-update pecl.php.net \
    && pecl install xdebug \
    && apk del $PHPIZE_DEPS \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-install pdo_pgsql

COPY xdebug.ini-override /tmp/xdebug.ini-override
RUN cat /tmp/xdebug.ini-override >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# composer
COPY --from=composer /usr/bin/composer /usr/bin/composer
ARG COMPOSER_BIN_DIR
ENV PATH=$PATH:${COMPOSER_BIN_DIR}
RUN apk add unzip

COPY ./docker-php-entrypoint.sh /docker-php-entrypoint.sh
ENTRYPOINT ["/docker-php-entrypoint.sh"]
