FROM php:8.4-cli-alpine

RUN apk add libffi-dev && docker-php-ext-install ffi

COPY --from=composer:2.8.9 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY composer.json .

RUN composer update -a --no-dev

COPY generate-subtitle .

ENTRYPOINT [ "php", "generate-subtitle" ]
