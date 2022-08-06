# httpd-php-docker-env

Docker environment template: Apache httpd & PHP-FPM

## Prerequisites

- Docker installed

## Get started

Execute the following command:

```shell
docker-compose up
```

## Customize httpd & php-fpm version

By default, we can configure the version strings in `.env`.
The variables are used for searching docker image names.
If an image not found, Docker will cause errors.

## Roadmap

We will add some sample codes as commented out.

e.g.:

- [ ] Configure SSL
- [ ] Install some PHP extensions
- More codes...
