# httpd-php-docker-env

Docker environment template: Apache httpd & PHP-FPM

## Prerequisites

- Docker installed

## Get started

First, copy `.env.template` and save it as `.env`:

```shell
cp .env.template .env
```

Then execute the following command:

```shell
docker compose up
```

## Run the examples application

Run the following commands from this directory (`_env/docker`). They create
the configuration files, start the containers in the background, and install
the dependencies used by `examples`.

```shell
cp .env.template .env
cp ../../examples/.env.example ../../examples/.env
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

By default, we can configure the version strings in `.env`.
The variables are used for searching docker image names.
If an image not found, Docker will cause errors.

## Roadmap

We will add some sample codes as commented out.

e.g.:

- [ ] Configure SSL
- [ ] Install some PHP extensions
- More codes...
