#!/bin/bash

cd ./_env/docker/php || exit

apt install -y libpq-dev \
    && pecl channel-update pecl.php.net \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-install pdo_pgsql
