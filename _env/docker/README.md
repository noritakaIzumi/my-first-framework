# httpd-php-docker-env

Docker environment template: Apache httpd & PHP-FPM

## Prerequisites

- Docker installed

## Run the examples application

Run the following commands from this directory (`_env/docker`). They start the
containers in the background and install the dependencies used by `examples`.

```shell
docker compose up --build -d
docker compose exec php sh -lc 'cd examples && composer install'
```

After the containers have started, open <http://localhost/hello>. The example
routes are defined in `../../examples/config/routes.php`; for example,
<http://localhost/goodbye> displays `Goodbye Mars.`.

To stop the environment, run:

```shell
docker compose down
```

If port 80 is already in use, stop the process using it or change the host
port mapping in `docker-compose.yaml` before starting the containers.

## Customize httpd & php-fpm version

The default versions are defined in `docker-compose.yaml`. To use another
version, set the corresponding environment variable when running Docker
Compose. For example:

```shell
PHP_VERSION=8.2 docker compose up --build
```

`HTTPD_VERSION`, `POSTGRES_VERSION`, and `POSTGRES_PASSWORD` can be overridden
in the same way.

## Roadmap

We will add some sample codes as commented out.

e.g.:

- [ ] Configure SSL
- [ ] Install some PHP extensions
- More codes...
