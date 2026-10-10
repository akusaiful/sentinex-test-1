#!/bin/sh
set -e
# Fresh SQLite per container: previews start clean; seed data comes from seeders.
touch database/database.sqlite
php artisan package:discover --ansi
php artisan migrate --force
# Seeders that need Faker require dev deps; enable only with production-safe seeders.
if [ "${DB_SEED:-false}" = "true" ]; then php artisan db:seed --force; fi
php artisan config:cache && php artisan route:cache && php artisan view:cache
for c in /etc/frankenphp/Caddyfile /etc/caddy/Caddyfile; do [ -f "$c" ] && exec frankenphp run --config "$c"; done
echo "No FrankenPHP Caddyfile found" >&2; exit 1
