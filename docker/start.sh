#!/bin/sh
set -e
# Run migrations against MySQL. Wait for the database to become available first.
if [ "${DB_CONNECTION:-mysql}" = "mysql" ]; then
  echo "Waiting for MySQL at ${DB_HOST:-127.0.0.1}:${DB_PORT:-3306}..."
  until php artisan migrate --force; do
    echo "MySQL not ready, retrying in 2 seconds..."
    sleep 2
  done
else
  php artisan migrate --force
fi
# Seeders that need Faker require dev deps; enable only with production-safe seeders.
if [ "${DB_SEED:-false}" = "true" ]; then php artisan db:seed --force; fi
php artisan config:cache && php artisan route:cache && php artisan view:cache
for c in /etc/frankenphp/Caddyfile /etc/caddy/Caddyfile; do [ -f "$c" ] && exec frankenphp run --config "$c"; done
echo "No FrankenPHP Caddyfile found" >&2; exit 1
