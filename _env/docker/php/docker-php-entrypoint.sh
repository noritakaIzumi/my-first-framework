#!/usr/bin/env ash

composer install

# Execute original entrypoint
. /usr/local/bin/docker-php-entrypoint php-fpm
