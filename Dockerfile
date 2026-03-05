FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql pdo_mysql zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

ENV COMPOSER_ALLOW_SUPERUSER=1
ENV APP_ENV=prod
ENV APP_SECRET=changeme

RUN composer install --no-dev --optimize-autoloader --no-scripts
RUN rm -f .env .env.local .env.local.php

EXPOSE 8080

CMD ["php", "-S", "0.0.0.0:8080", "-t", "public/"]

