# Contributing

## Setup

```bash
git clone git@github.com:owowagency/laravel-resources.git
cd laravel-resources
composer install
```

## Docker

A [docker-compose.yml](./docker-compose.yml) file is present in this repository to make development easier.

```bash
docker compose up -d
docker exec -it laravel_resources_php /bin/bash
```

## Code style

Follow the code styling defined in [pint.json](./pint.json).

```bash
vendor/bin/pint
```

## Testing

All code of this package is tested using [PHPUnit](https://phpunit.de/).

```bash
vendor/bin/phpunit
```
