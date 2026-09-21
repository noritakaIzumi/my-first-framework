ARG PHP_VERSION

FROM alpine AS xdebug-config

WORKDIR /xdebug
COPY xdebug.ini-override* ./
RUN if [ ! -f xdebug.ini-override ]; then \
        cp xdebug.ini-override.template xdebug.ini-override; \
    fi

FROM php:${PHP_VERSION}-fpm-alpine

RUN apk update \
    && apk add --update linux-headers \
    && apk add $PHPIZE_DEPS libpq-dev \
    && pecl channel-update pecl.php.net \
    && pecl install xdebug \
    && apk del $PHPIZE_DEPS \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-install pdo_pgsql

COPY --from=xdebug-config /xdebug/xdebug.ini-override /tmp/xdebug.ini-override
RUN cat /tmp/xdebug.ini-override >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# composer
COPY --from=composer /usr/bin/composer /usr/bin/composer
ARG COMPOSER_BIN_DIR
ENV PATH=$PATH:${COMPOSER_BIN_DIR}
RUN apk add unzip

COPY ./docker-php-entrypoint.sh /docker-php-entrypoint.sh
RUN chmod a+x /docker-php-entrypoint.sh
ENTRYPOINT ["/docker-php-entrypoint.sh"]
