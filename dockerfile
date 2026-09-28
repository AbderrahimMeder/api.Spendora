FROM php:8.4-cli

RUN apt-get update -y && apt-get install -y \
    libmariadb-dev \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_mysql \
    && pecl install redis \
    && docker-php-ext-enable redis

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

CMD bash -c "composer install && php artisan serve --host=0.0.0.0 --port=8000"