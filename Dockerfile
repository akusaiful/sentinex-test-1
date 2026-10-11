# Production image for Coolify (main deploys and PR previews). Uses MySQL via docker-compose.
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --no-interaction --ignore-platform-reqs
COPY . .
RUN composer dump-autoload --optimize --no-dev --no-scripts

FROM dunglas/frankenphp:1-php8.3
RUN install-php-extensions pdo_mysql intl zip opcache
WORKDIR /app
COPY --from=vendor /app /app
ENV SERVER_NAME=:80 APP_ENV=production LOG_CHANNEL=stderr
RUN rm -f bootstrap/cache/*.php \
 && mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs database \
 && chown -R www-data:www-data storage bootstrap/cache database \
 && chmod +x docker/start.sh
EXPOSE 80
CMD ["docker/start.sh"]
