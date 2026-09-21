#!/usr/bin/env ash

composer install
chmod -v a+w /workspace/examples/_log

# Execute original entrypoint
. /usr/local/bin/docker-php-entrypoint php-fpm
