FROM composer:2 AS composer

WORKDIR /app
RUN apk add --no-cache icu-dev \
    && docker-php-ext-install -j$(nproc) intl
COPY composer.json composer.lock* ./
RUN set -eux; \
    if [ -f composer.lock ]; then \
      composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader --no-scripts || \
      composer update --no-dev --prefer-dist --no-interaction --optimize-autoloader --no-scripts; \
    else \
      composer update --no-dev --prefer-dist --no-interaction --optimize-autoloader --no-scripts; \
    fi

FROM php:8.4-fpm-alpine

RUN apk add --no-cache \
    bash \
    curl \
    mysql-client \
    icu-dev \
    libzip-dev \
    oniguruma-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libwebp-dev \
    libxml2-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j$(nproc) pdo_mysql mbstring intl zip gd bcmath opcache \
    && rm -rf /var/cache/apk/*

WORKDIR /var/www/html

COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY --from=composer /app/vendor /var/www/html/vendor
COPY . /var/www/html

RUN if [ -f .env.example ]; then cp .env.example .env; else touch .env; fi \
    && composer dump-autoload --no-dev --optimize \
    && php artisan package:discover --ansi \
    && mkdir -p storage/logs storage/framework/cache storage/framework/sessions storage/framework/views storage/app/public \
    && chown -R www-data:www-data storage bootstrap/cache

ENV PHP_UPLOAD_MAX_FILESIZE=10M
ENV PHP_POST_MAX_SIZE=12M

RUN { \
      echo 'upload_max_filesize=10M'; \
      echo 'post_max_size=12M'; \
      echo 'memory_limit=256M'; \
      echo 'max_execution_time=120'; \
    } > /usr/local/etc/php/conf.d/uploads.ini

COPY docker/entrypoint.sh /usr/local/bin/nails-entrypoint
RUN chmod +x /usr/local/bin/nails-entrypoint

EXPOSE 9000

ENTRYPOINT ["nails-entrypoint"]
