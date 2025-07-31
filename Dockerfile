FROM php:8.4-cli-alpine

RUN apk add libffi-dev && docker-php-ext-install ffi

COPY --from=composer:2.8.9 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY composer.json .

RUN composer install -a --no-dev

COPY generate-subtitle.php .

ENTRYPOINT [ "php", "generate-subtitle.php" ]
